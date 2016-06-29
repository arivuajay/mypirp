<?php

class BookordersController extends Controller {
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
                'expression'=> "AdminIdentity::checkAccess('webpanel.bookorders.{$this->action->id}')",
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
        $model = new BookOrders;
        $model->scenario = "create";

        $model->unsetAttributes();

        $affiliates = DmvAffiliateInfo::all_affliates();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['BookOrders'])) {
            $model->attributes = $_POST['BookOrders'];

            $model->client_type = ($model->book_instructor == 1) ? "I" : "A";
            $model->book_instructor = ($model->book_instructor == 1) ? "Y" : "N";
            $model->payment_complete = ($model->payment_complete == 1) ? "Y" : "N";
            $model->payment_date = Myclass::dateformat($model->payment_date);
            if ($model->save()) {
                Myclass::addAuditTrail("Book order created  successfully. Book id - {$model->book_id} ", "bookorders");
                Yii::app()->user->setFlash('success', 'BookOrders Created Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', compact('model', 'affiliates'));
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

        if (isset($_POST['BookOrders'])) {
            $model->attributes = $_POST['BookOrders'];
            $model->payment_complete = ($model->payment_complete == 1) ? "Y" : "N";
            $model->payment_date = Myclass::dateformat($model->payment_date);
            if ($model->save()) {
                Myclass::addAuditTrail("Book order updated  successfully. Book id - {$model->book_id} ", "bookorders");
                Yii::app()->user->setFlash('success', 'BookOrders Updated Successfully!!!');
                $this->redirect(array('index'));
            }
        }
        
         $model->payment_date = Myclass::date_dispformat($model->payment_date);

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
        Myclass::addAuditTrail("Book order deleted successfully. Book id - {$model->book_id} ", "bookorders");
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'BookOrders Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new BookOrders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BookOrders']))
            $model->attributes = $_GET['BookOrders'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return BookOrders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = BookOrders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param BookOrders $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'book-orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
