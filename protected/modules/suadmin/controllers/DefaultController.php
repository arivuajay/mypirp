<?php
class DefaultController extends Controller {
 
    public $layout = '//layouts/column1';

    /**
     * @array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'error', 'forgotpassword'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('logout', 'index', 'profile','changepassword','createaffiliate'),
                'users' => array('@'),
                'expression'=> 'SuAdminIdentity::checkAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionCreateaffiliate(){
        $model = new DmvAffiliateInfo;
        $refmodel = new DmvAffiliateCommission;
        
        $admininfos = Admin::model()->findAll(array("order" => "username"));
        $adminvals = CHtml::listData($admininfos, 'admin_id', 'username');

        $model->unsetAttributes();  // clear any default values

        if (isset($_POST['DmvAffiliateInfo'])) {
            $model->attributes = $_POST['DmvAffiliateInfo'];
            $refmodel->attributes = $_POST['DmvAffiliateCommission'];

            $valid = $model->validate();
            $valid = $refmodel->validate() && $valid;
            if ($valid) {
                $model->aff_created_date = date("Y-m-d",time());
                $model->sponsor_code = "28";
                $model->file_type    = "QTR";
                $model->record_type  = "A";
                $model->trans_type   = "X";               
                if ($model->save()) {                    
                    $refmodel->affiliate_id = $model->affiliate_id;
                    $refmodel->save();
                    Yii::app()->user->setFlash('success', 'Affiliate account created successfully.!!!');
                    $this->redirect(array('createaffiliate'));
                }
            }
        }

        $this->render('createaffiliate', compact('model', 'refmodel','adminvals'));
    }

    public function actionIndex() 
    {      
        $total_admins    = Admin::model()->count();
        $total_affs      = DmvAffiliateInfo::model()->count();
        $total_ins       = DmvAddInstructor::model()->count();
        // Schedules
        $criteria = new CDbCriteria;
        $criteria->addCondition("show_admin = 'Y'");  
        $criteria->addCondition("Affliate.affiliate_id != ''"); 
        $criteria->with = array("Affliate");
        $criteria->together = true;
        $total_schedules = DmvClasses::model()->count($criteria);
        $total_students  = Students::model()->count();
        $this->render('index', compact('total_admins','total_affs','total_ins','total_schedules','total_students'));
    }
    

    public function actionLogin() 
    {
        $this->layout = '//layouts/login';
        
        if (!Yii::app()->user->isGuest) 
        {
            $param_str = Yii::app()->getRequest()->getQuery('str');
            if ($param_str!='')
            {  
                $decodeurl = Myclass::refdecryption($param_str); 
                $this->redirect($decodeurl);  
            }  
            $this->redirect(array('/suadmin/default/index'));               
        }  
        
        $model = new SuAdminLoginForm();
 
        if (isset($_POST['sign_in'])) {
            $model->attributes = $_POST['SuAdminLoginForm'];
            if ($model->validate() && $model->login()):                
                $param_str = Yii::app()->getRequest()->getQuery('str');
                if ($param_str!='')
                {  
                    $decodeurl = Myclass::refdecryption($param_str); 
                    $this->redirect($decodeurl);  
                }    
                $this->redirect(array('/suadmin/default/index'));              
            endif;
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout() 
    {       
        Yii::app()->user->logout();
        $this->redirect(array('/suadmin/default/login'));
    }

    public function actionForgotpassword() 
    {
        
        $this->layout = '//layouts/login';

        if (!Yii::app()->user->isGuest) 
        {
            $this->redirect(array('/suadmin/default/index'));
        }
        
        $model = new PasswordResetRequestForm();
        if (isset($_POST['PasswordResetRequestForm'])) 
        {
            $model->attributes = $_POST['PasswordResetRequestForm'];
            if ($model->validate() && $model->suadmin_authenticate()):                    
                Yii::app()->user->setFlash('success', Myclass::t('APP17'));
                $this->redirect(array('/suadmin/default/login'));     
            endif;
        }

        $this->render('forgotpassword', array(
            'model' => $model,
        ));
    }
    
    public function actionChangepassword()
    {      
        $id    = Yii::app()->user->id;       
        $model = SuAdmin::model()->findByAttributes(array('id'=>$id));
        $model->setScenario('changepassword');

        if(isset($_POST['SuAdmin']))
        {
            $model->attributes = $_POST['SuAdmin'];              
            if($model->validate())
            {  
              $model->password = Myclass::refencryption($_POST['SuAdmin']['current_password']);                
              if($model->save(false))
              {                  
                Yii::app()->user->setFlash('success', Myclass::t('APP18'));
                $this->redirect(array('/suadmin/default/changepassword'));    
              }else
              {  
                Yii::app()->user->setFlash('error', Myclass::t('APP19'));
                $this->redirect(array('/suadmin/default/changepassword'));                   
              }   
            }
        }else
        {
             unset($model->password); 
        }

        $this->render('changepassword',array('model'=>$model)); 
    }

    public function actionProfile() 
    {
        $id    = Yii::app()->user->id;
        $model = SuAdmin::model()->findByPk($id);
        
        $this->performAjaxValidation($model);
        
        if (isset($_POST['SuAdmin'])) {
            $model->attributes = $_POST['SuAdmin'];
            if ($model->validate()):    
                $model->save(false);
                Yii::app()->user->setFlash('success', Myclass::t('APP20'));
                $this->refresh();
            endif;
        }
        $this->render('profile', compact('model'));
    }

    public function actionError() 
    {
        $this->layout = '//layouts/anonymous_page';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
                Yii::app()->end();
            } else {
                $name = Yii::app()->errorHandler->error['code'] . ' Error';
                $message = Yii::app()->errorHandler->error['message'];
                $this->render('error', compact('error', 'name', 'message'));
            }
        }
    }
    
    /**
	 * Performs the AJAX validation.
	 * @param Admin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}