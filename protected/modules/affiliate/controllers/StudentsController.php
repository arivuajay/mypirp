<?php

class StudentsController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'delete', 'addbulkstudents', 'managestudents', 'viewstudents', 'printstudents', 'printlabels', 'getclasses'),
                'users' => array('@'),
                'expression' => 'AffiliateIdentity::checkAffiliate()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function checkVisible($print_certificate) {
        if ($print_certificate == "Y")
            return false;
        else
            return true;
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

    public function actionPrintstudents() {
        $model = new Students('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Students']))
            $model->attributes = $_GET['Students'];

        $this->render('printstudents', compact('model'));
    }

    public function actionPrintlabels() {
        $model = new Students('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Students'])) {
            $model->attributes = $_GET['Students'];

            $startdate = $model->startdate;
            $enddate = $model->enddate;

            $criteria = new CDbCriteria;
            $criteria->addCondition('first_name != ""');
            $criteria->addCondition('affiliate_id = ' . Yii::app()->user->affiliate_id);

            if ($startdate != "" && $enddate != "")
                $criteria->addCondition("course_completion_date >= '" . Myclass::dateformat($startdate) . "' AND course_completion_date <= '" . Myclass::dateformat($enddate) . "'");

            $std_infos = Students::model()->findAll($criteria);

            if (!empty($std_infos)) {
                $html2pdf = Yii::app()->ePdf->HTML2PDF();
                $html2pdf->WriteHTML($this->renderPartial('printlabel_view', array("std_infos" => $std_infos), true));
                $html2pdf->Output(time() . ".pdf", EYiiPdf::OUTPUT_TO_DOWNLOAD);
            } else {
                Yii::app()->user->setFlash('danger', 'No records found!!!');
                $this->redirect(array('printlabels'));
            }
        }

        $this->render('printlabels', compact('model'));
    }

    public function getcertificatenumber($student_id, $clas_id) {
        $certificate_number = "-";

        if ($student_id != "" && $clas_id != "") {
            $condition = "student_id=" . $student_id . " and class_id=" . $clas_id;
            $certificate_result = PrintCertificate::model()->find($condition);

            if (!empty($certificate_result))
                $certificate_number = $certificate_result->certificate_number;
        }

        return $certificate_number;
    }

    public function actionAddbulkstudents($cid) {
        $model = new Students;        

        $aid = Yii::app()->user->affiliate_id;

        $flag = 0;
        if (isset($_POST['Students'])) {
            for ($i = 1; $i <= 20; $i++) {
                if (isset($_POST['Students'][$i]['first_name']) && trim($_POST['Students'][$i]['first_name']) != '') {
                    $model = new Students;
                    $model->attributes = $_POST['Students'][$i];

                    if (isset($_POST['Students']['completion_date_all']) && $_POST['Students']['completion_date_all'] == "Yes" && isset($_POST['Students'][1]['course_completion_date']) && $_POST['Students'][1]['course_completion_date'] != "") {
                        $model->course_completion_date = Myclass::dateformat($_POST['Students'][1]['course_completion_date']);
                    } elseif ($model->course_completion_date != "") {
                        $model->course_completion_date = Myclass::dateformat($model->course_completion_date);
                    }

                    if ($model->dob != "") {
                        $model->dob = Myclass::dateformat($model->dob);
                    }

                    $model->affiliate_id = $aid;
                    $model->clas_id = $cid;
                    $model->save();
                    $flag++;
                }
            }

            if ($flag > 0) {
                Yii::app()->user->setFlash('success', $flag . ' student(s) added successfully!!!');
                $this->redirect(array('schedules/index'));
            } else {
                Yii::app()->user->setFlash('danger', 'Please fill atleast one student details to save!!!');
                $this->redirect(array('students/addbulkstudents/cid/' . $cid));
            }
        }
        
        if ($model->course_completion_date == "0000-00-00") {
            $model->course_completion_date = "";
        }
        
        if ($model->dob == "0000-00-00") {
            $model->dob = "";
        }

        $this->render('addbulkstudents', compact('model'));
    }

    public function actionManagestudents() {
        $model = new DmvClasses;
        //$affiliates = DmvAffiliateInfo::all_affliates("Y");

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvClasses']))
            $model->attributes = $_GET['DmvClasses'];

        //$this->render('managestudents', compact('model', 'affiliates'));
        $this->render('managestudents', compact('model'));
    }

    public function actionViewstudents($cid) {
        $model = new Students('search');
        $print_certificate = "N";

        $model->unsetAttributes();  // clear any default values

        $model->affiliate_id = Yii::app()->user->affiliate_id;
        $model->clas_id = $cid;

        if (isset($_GET['Students']))
            $model->attributes = $_GET['Students'];

        if ($cid != "") {
            $print_certificate = Payment::model()->find("class_id=" . $cid)->print_certificate;
        }

        $this->render('viewstudents', compact('model', 'print_certificate'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Students;
        $model->scenario = "create";

        $affid = Yii::app()->user->affiliate_id;
        $classes = DmvClasses::all_classes($affid);


        $model->affiliate_id = Yii::app()->user->affiliate_id;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Students'])) {
            $model->attributes = $_POST['Students'];
            $model->dob = ($model->dob != "") ? Myclass::dateformat($model->dob) : "";
            $model->course_completion_date = ($model->course_completion_date != "") ? Myclass::dateformat($model->course_completion_date) : "";
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Student created successfully!!!');
                $this->redirect(array('index'));
            }
        }
        
        if ($model->course_completion_date == "0000-00-00") {
            $model->course_completion_date = "";
        } 

        if ($model->dob == "0000-00-00") {
            $model->dob = "";
        } 


        $this->render('create', compact('model', 'affiliates', 'classes'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = "create";

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Students'])) {
            $model->attributes = $_POST['Students'];
            $model->dob = ($model->dob != "") ? Myclass::dateformat($model->dob) : "";
            $model->course_completion_date = ($model->course_completion_date != "") ? Myclass::dateformat($model->course_completion_date) : "";
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Student Updated Successfully!!!');
                $this->redirect(array('students/viewstudents/cid/' . $model->clas_id));
            }
        }

        if ($model->course_completion_date == "0000-00-00") {
            $model->course_completion_date = "";
        } else {
            $model->course_completion_date = Myclass::date_dispformat($model->course_completion_date);
        }

        if ($model->dob == "0000-00-00") {
            $model->dob = "";
        } else {
            $model->dob = Myclass::date_dispformat($model->dob);
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Students Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Students('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Students']))
            $model->attributes = $_GET['Students'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Students the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Students::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Students $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'students-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
