<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/aff_column1';

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
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionIndex() 
    {      
        // Schedules
        $criteria = new CDbCriteria;
        $criteria->addCondition("show_admin = 'Y'");         
        $criteria->addCondition("Affliate.affiliate_id = ".Yii::app()->user->affiliate_id);
        $criteria->with = array("Affliate");
        $criteria->together = true;
        $total_schedules = DmvClasses::model()->count($criteria);
        
        //students
        $total_students  = Students::model()->count("affiliate_id = ".Yii::app()->user->affiliate_id);
        
        // Documents
        $criteria2 = new CDbCriteria;
        $admin_id = DmvAffiliateInfo::model()->findByPk(Yii::app()->user->affiliate_id)->admin_id;
        $criteria2->condition = "admin_id = :admin_id";
        $criteria2->params = (array(':admin_id' => $admin_id));
        $criteria2->addCondition("affiliate_id = ".Yii::app()->user->affiliate_id." || affiliate_id=0");  
        $total_documents = PostDocument::model()->count($criteria2);
        
        // Messages
        $total_messages  = DmvPostMessage::model()->count($criteria2);
        
        $this->render('index', compact('total_schedules','total_students','total_documents','total_messages'));
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
            $this->redirect(array('/affiliate/default/login'));               
        }  
        
        $model = new AffiliateLoginForm();
 
        if (isset($_POST['sign_in'])) {
            $model->attributes = $_POST['AffiliateLoginForm'];
            if ($model->validate() && $model->login()):   
                
                $param_str = Yii::app()->getRequest()->getQuery('str');
                
                if ($param_str!='')
                {  
                    $decodeurl = Myclass::refdecryption($param_str); 
                    $this->redirect($decodeurl);  
                }    
                $this->redirect(array('/affiliate/default/index'));              
            endif;
        }

        $this->render('login', array('model' => $model));
    }
    public function actionLogout() 
    {       
        Yii::app()->user->logout();
        $this->redirect(array('/affiliate/default/login'));
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
}