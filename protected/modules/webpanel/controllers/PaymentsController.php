<?php

class PaymentsController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'getclasses'),
                'users' => array('@'),
                'expression'=> "AdminIdentity::checkAccess('webpanel.payments.{$this->action->id}')",
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
        $model = new Payment;
        $model->scenario = "create";

        $affiliates = DmvAffiliateInfo::all_affliates();
        $schedules = array();

        $model->unsetAttributes();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Payment'])) {

            $model->attributes = $_POST['Payment'];
            $model->payment_complete = ($model->payment_complete == 1) ? "Y" : "N";
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Payment Created Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('create', compact('model', 'affiliates'));
    }

    public function actionGetclasses() {

        $options = "<option value=''>Select Class</option>";
        $affid = isset($_POST['id']) ? $_POST['id'] : '';

        if ($affid != "") {
            /* Get paymented classes of the affliates */
            $criteria = new CDbCriteria;
            $criteria->select = 't.payment_id,t.class_id';
            $criteria->addCondition("Affliate.admin_id='" . Yii::app()->user->admin_id . "'");
            $criteria->addCondition("dmvClasses.affiliate_id='" . $affid . "'");
            $criteria->with = array("dmvClasses", "dmvClasses.Affliate");
            $criteria->together = true;
            $class_payments = Payment::model()->findAll($criteria);
            $val = CHtml::listData($class_payments, 'class_id', 'class_id');

            /* Get all classes of the affliates */
            $data_Classes = DmvClasses::all_classes($affid);

            /* Get unpaymane classes */
            $finalarray = array_diff_key($data_Classes, $val);

            if (!empty($finalarray)) {
                foreach ($finalarray as $k => $info) {
                    $options .= "<option value='" . $k . "'>" . $info . "</option>";
                }
            }
        }
        echo $options;
        exit;
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

        if (isset($_POST['Payment'])) {
            $model->attributes = $_POST['Payment'];
            $model->payment_complete = ($model->payment_complete == 1) ? "Y" : "N";
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Payment Updated Successfully!!!');
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
        $pmodel = $this->loadModel($id);
        $class_id = $pmodel->class_id;
        
        PrintCertificate::model()->deleteAll("class_id=".$class_id);
        Students::model()->deleteAll("clas_id=".$class_id);
        DmvClasses::model()->deleteAll("clas_id=".$class_id);
        $pmodel->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Payment Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Payment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Payment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Payment $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
