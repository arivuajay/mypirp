<?php

class MessagesController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/aff_column1';
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view'),
                'expression'=> "AffiliateIdentity::checkAffiliate()",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView() {
        $id = $_POST['id'];
        if($id!="")
        {    
            $messageinfo = $this->loadModel($id);
            echo nl2br($messageinfo->descr);
            exit;
        }    
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        
        $model = new DmvPostMessage('search');
        
        $criteria2 = new CDbCriteria;     
        $criteria2->addCondition("view_status = 0");
        $criteria2->addCondition("affiliate_id = ".Yii::app()->user->affiliate_id);
        $total_messages  = DmvPostMessage::model()->count($criteria2);
        
        if($total_messages>0)
        { 
            DmvPostMessage::model()->updateAll(array('view_status'=>'1'),$criteria2);
        }    
        
        
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvPostMessage']))
            $model->attributes = $_GET['DmvPostMessage'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DmvPostMessage the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DmvPostMessage::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
