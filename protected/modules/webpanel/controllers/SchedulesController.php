<?php

class SchedulesController extends Controller {
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
        $instructors = array();
        $model = new DmvClasses;
        $affiliates = DmvAffiliateInfo::all_affliates();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvClasses'])) {
            $model->attributes = $_POST['DmvClasses'];

            if ($model->affiliate_id) {
                $instructors = DmvAddInstructor::all_instructors($model->affiliate_id);
            }

            $model->show_admin = "Y";
            if ($model->save()) {

                for ($j = 3; $j <= 10; $j++) {
                    /* Save other schedules in different dates with same records */
                    if (isset($_POST['txt_Date' . $j]) && $_POST['txt_Date' . $j] != '') {
                        $dt = $_POST['txt_Date' . $j];
                        list($y, $m, $d) = explode("-", $dt);
                        if (checkdate($m, $d, $y)) {

                            $condition = "affiliate_id='" . $model->affiliate_id . "' and  clas_date='" . $dt . "' and start_time='" . $model->start_time . "' and end_time='" . $model->end_time . "' and instructor_id='" . $model->instructor_id . "'";
                            $scheduleexist = DmvClasses::model()->count($condition);
                            
                            if ($scheduleexist == 0) {
                                $smodel = new DmvClasses;
                                $smodel->affiliate_id = $model->affiliate_id;
                                $smodel->clas_date = $dt;
                                $smodel->start_time = $model->start_time;
                                $smodel->end_time = $model->end_time;
                                $smodel->location = $model->location;
                                $smodel->loc_addr = $model->loc_addr;
                                $smodel->loc_city = $model->loc_city;
                                $smodel->loc_state = $model->loc_state;
                                $smodel->zip = $model->zip;
                                $smodel->country = $model->country;
                                $smodel->instructor_id = $model->instructor_id;
                                $smodel->show_admin = "Y";
                                $smodel->save();
                            }
                        }
                    }
                }

                Yii::app()->user->setFlash('success', 'Classes Created Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        if ($model->clas_date == "0000-00-00") {
            $model->clas_date = "";
        }

        if ($model->date2 == "0000-00-00") {
            $model->date2 = "";
        }

        $this->render('create', compact('model', 'affiliates', 'instructors'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $affiliates = DmvAffiliateInfo::all_affliates();
        $instructors = DmvAddInstructor::all_instructors($model->affiliate_id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvClasses'])) {
            $model->attributes = $_POST['DmvClasses'];
            $model->show_admin = "Y";
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Class Updated Successfully!!!');
                $this->redirect(array('index'));
            }
        }
        
        if ($model->clas_date == "0000-00-00") {
            $model->clas_date = "";
        }

        if ($model->date2 == "0000-00-00") {
            $model->date2 = "";
        }

        $this->render('update', compact('model', 'affiliates', 'instructors'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        
//        $querydel	 = "Delete from dmv_payment where class_id='$id'";
//        $querydel2	= "Delete from dmv_print_certificate where class_id='$id'";
//        $querydel3	= "Delete from dmv_students  where clas_id='$id'";
        
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Class(es) Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new DmvClasses('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvClasses']))
            $model->attributes = $_GET['DmvClasses'];

        $this->render('index', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DmvClasses the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DmvClasses::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DmvClasses $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dmv-classes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
