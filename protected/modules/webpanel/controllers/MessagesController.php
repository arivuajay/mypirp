<?php

class MessagesController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'expression'=> "AdminIdentity::checkAccess('webpanel.messages.{$this->action->id}')",
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new DmvPostMessage;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        
        $model->unsetAttributes();  // 
        if (isset($_POST['DmvPostMessage'])) {
            $model->attributes = $_POST['DmvPostMessage'];
            $model->admin_id = Yii::app()->user->admin_id;
            if ($model->save()) {
                Myclass::addAuditTrail("{$model->message_title} message created successfully. Message id - {$model->message_id}", "messages");
                
                Yii::app()->user->setFlash('success', 'Message Created Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvPostMessage'])) {
            $model->attributes = $_POST['DmvPostMessage'];
            $model->admin_id = Yii::app()->user->admin_id;
            if ($model->save()) {
                Myclass::addAuditTrail("{$model->message_title} message updated successfully. Message id - {$model->message_id}", "messages");
               
                Yii::app()->user->setFlash('success', 'Message Updated Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        
        $model = $this->loadModel($id);
        Myclass::addAuditTrail("{$model->message_title} message deleted successfully. Message id - {$model->message_id}", "messages");        
        $model->delete();


        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Message Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new DmvPostMessage('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvPostMessage']))
            $model->attributes = $_GET['DmvPostMessage'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new DmvPostMessage('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvPostMessage']))
            $model->attributes = $_GET['DmvPostMessage'];

        $this->render('admin', array(
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

    /**
     * Performs the AJAX validation.
     * @param DmvPostMessage $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dmv-post-message-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
