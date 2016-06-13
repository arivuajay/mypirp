<?php

class DefaultController extends Controller
{
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
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionIndex() 
    {      
        
        $this->render('index');
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