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
        
        $total_students = 0;
        
        $this->render('index', compact('total_schedules','total_students'));
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
}