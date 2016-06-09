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
                'actions' => array('logout', 'index', 'profile','changepassword'),
                'users' => array('@'),
                'expression'=> 'AdminIdentity::checkAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    

    public function actionIndex() 
    {      
        //$total_websites = Websites::model()->count();
       // $total_courses  = Courses::model()->count();
        $total_websites = "12313";
        $total_courses  = "12313";
        $this->render('index', array('total_websites' => $total_websites,'total_courses' => $total_courses));
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