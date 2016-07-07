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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'exceldownload', 'deleteselectedall'),
                'expression' => "AdminIdentity::checkAccess('webpanel.schedules.{$this->action->id}')",
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
        //$model->unsetAttributes();  // clear 
        
        $affiliates = DmvAffiliateInfo::all_affliates();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvClasses'])) {
            $model->attributes = $_POST['DmvClasses'];

            if ($model->affiliate_id) {
                $instructors = DmvAddInstructor::all_instructors($model->affiliate_id);
            }

            $model->show_admin = "Y";
            $model->clas_date = ($model->clas_date!="")?Myclass::dateformat($model->clas_date):"";
            $model->date2 = ( $model->date2!="" )?Myclass::dateformat($model->date2):"";
            if ($model->save()) {
                $otherdates = array();
                for ($j = 3; $j <= 10; $j++) {
                    /* Save other schedules in different dates with same records */
                    if (isset($_POST['txt_Date' . $j]) && $_POST['txt_Date' . $j] != '') {
                        $dt = Myclass::dateformat($_POST['txt_Date' . $j]);
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
                                $otherdates[] = date("F d,Y", strtotime($dt));
                            }
                        }
                    }
                }

                $otherschedules = (!empty($otherdates)) ? " and other scheduled dates " . implode(",", $otherdates) : "";
                $audit_desc = date("F d,Y", strtotime($model->clas_date)) . " " . $model->start_time . " to " . $model->end_time . " Class id - {$model->clas_id} " . $otherschedules;

                Myclass::addAuditTrail("Schedules {$audit_desc} created successfully.", "schedules");
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
            $model->clas_date = Myclass::dateformat($model->clas_date);
            $model->date2 = ( $model->date2!="0000-00-00" )?Myclass::dateformat($model->date2):"";
            if ($model->save()) {
                $audit_desc = date("F d,Y", strtotime($model->clas_date)) . " " . $model->start_time . " to " . $model->end_time;
                Myclass::addAuditTrail("Schedule {$audit_desc} updated successfully. Class id - {$model->clas_id}", "schedules");
                Yii::app()->user->setFlash('success', 'Class Updated Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        if ($model->clas_date == "0000-00-00") {
            $model->clas_date = "";
        }else{
            $model->clas_date = Myclass::date_dispformat($model->clas_date);
        } 

        if ($model->date2 == "0000-00-00") {
            $model->date2 = "";
        }else{
            $model->date2 = Myclass::date_dispformat($model->date2);
        } 

        $this->render('update', compact('model', 'affiliates', 'instructors'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        Payment::model()->deleteAll("class_id='$id'");
        PrintCertificate::model()->deleteAll("class_id='$id'");
        Students::model()->deleteAll("clas_id='$id'");

        $model = $this->loadModel($id);
        $audit_desc = date("F d,Y", strtotime($model->clas_date)) . " " . $model->start_time . " to " . $model->end_time;
        Myclass::addAuditTrail("Schedule {$audit_desc} and the related payments , students , certificates deleted successfully. Class id - {$id}", "schedules");

        $model->delete();

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
        if (isset($_REQUEST['success'])) {

            if ($_REQUEST['success'] == 'deleted') {
                Yii::app()->user->setFlash('success', 'Class(es) Deleted Successfully!!!');
            }

            $this->redirect(array('/webpanel/schedules/index'));
        }
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

    public function actionExceldownload() {

        $from_date = '';
        $to_date = '';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['DmvClasses'])) {
            $from_date = $_GET['DmvClasses']['startdate'];
            $to_date = $_GET['DmvClasses']['enddate'];

            $ret_result = Yii::app()->db->createCommand("SELECT dmc.clas_id as 'Class ID',dmc.clas_date as 'Class Date',dmc.start_time as 'Start Time',dmc.end_time as 'End Time',
               dmc.loc_city as 'City',dmc.loc_state as 'State',dmc.zip as 'Zip',dmi.ins_first_name as 'Instructor First Name',dmi.instructor_last_name as 'Instructor Last Name',dma.agency_code as 'Agency Code'
               FROM dmv_classes as dmc,dmv_add_instructor as dmi,dmv_affiliate_info as dma  WHERE  dma.admin_id = '" . $admin_id . "' AND dmc.affiliate_id = dma.affiliate_id AND dmc.instructor_id = dmi.instructor_id AND dmc.show_admin='Y' AND dmc.clas_date >= '" . Myclass::dateformat($from_date) . "' AND dmc.clas_date <= '" . Myclass::dateformat($to_date) . "'");
            $file_name = 'schedules_' . date('m-d-Y') . '.csv';

            Yii::import('ext.ECSVExport');
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
            exit();
        }

        $this->redirect(array('index'));
    }

    public function actionDeleteselectedall() {
        $idList = Yii::app()->request->getParam('idList');
        $ids = '';
        if ($idList) {
            foreach ($idList as $id) {
                Payment::model()->deleteAll("class_id='$id'");
                PrintCertificate::model()->deleteAll("class_id='$id'");
                Students::model()->deleteAll("clas_id='$id'");

                $model = $this->loadModel($id);
                $audit_desc = date("F d,Y", strtotime($model->clas_date)) . " " . $model->start_time . " to " . $model->end_time;
                Myclass::addAuditTrail("Schedule {$audit_desc} and the related payments , students , certificates deleted successfully. Class id - {$id}", "schedules");

                $model->delete();
            }
        }
        echo 'deleted';
    }

}
