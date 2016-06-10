<?php

class AffiliatesController extends Controller {
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
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('admin'),
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
        $model = new DmvAffiliateInfo;
        $refmodel = new DmvAffiliateCommission;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if (isset($_POST['DmvAffiliateInfo'])) {
            $model->attributes = $_POST['DmvAffiliateInfo'];
            $refmodel->attributes = $_POST['DmvAffiliateCommission'];

            $valid = $model->validate();
            $valid = $refmodel->validate() && $valid;
            if ($valid) {
                $model->admin_id = Yii::app()->user->admin_id;
                if ($model->save()) {
                    $refmodel->affiliate_id = $model->affiliate_id;
                    $refmodel->save();
                    Yii::app()->user->setFlash('success', 'New Account has been created successfully.!!!');
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('create', compact('model', 'refmodel'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $refmodel = DmvAffiliateCommission::model()->find("affiliate_id=" . $model->affiliate_id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvAffiliateInfo'])) {
            $model->attributes = $_POST['DmvAffiliateInfo'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'DmvAffiliateInfo Updated Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        $this->render('update', compact('model', 'refmodel'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        
//        $querydel1	= "Delete from dmv_aff_instructor where affiliate_id='$affiliate_id'";
//	$querydel2	= "Delete from dmv_book_orders where affiliate_id='$affiliate_id'";
//	$querydel3	= "Delete from dmv_classes  where affiliate_id='$affiliate_id'";
//	$querydel4	= "Delete from dmv_leaders_guide where affiliate_id='$affiliate_id'";
//	$querydel5	= "Delete from dmv_students  where affiliate_id='$affiliate_id'";
	DmvAffiliateCommission::model()->deleteAllByAttributes(array("affiliate_id" => $id));
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'DmvAffiliateInfo Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new DmvAffiliateInfo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvAffiliateInfo']))
            $model->attributes = $_GET['DmvAffiliateInfo'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DmvAffiliateInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DmvAffiliateInfo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DmvAffiliateInfo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dmv-affiliate-info-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
