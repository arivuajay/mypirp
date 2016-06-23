<?php

class StudentsController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'addbulkstudents', 'managestudents', 'viewstudents', 'printstudents', 'getclasses','exceldownload'),
                'expression'=> "AdminIdentity::checkAccess('webpanel.students.{$this->action->id}')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function checkVisible($print_certificate) {
        if ($print_certificate != "" && $print_certificate != "Y")
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

        $affiliates_arr = DmvAffiliateInfo::all_affliates();
        $firstItem = array('0' => '- ALL -');
        $affiliates = $firstItem + $affiliates_arr;

        $instructors_arr = DmvAddInstructor::all_instructors();
        $scndItem = array('0' => '- None -');
        $instructors = $scndItem + $instructors_arr;



        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Students']))
            $model->attributes = $_GET['Students'];

        $this->render('printstudents', compact('model', 'affiliates', 'instructors'));
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

    public function actionAddbulkstudents($aid, $cid) {
        $model = new Students;
        $flag = 0;
        if (isset($_POST['Students'])) {
            for ($i = 1; $i <= 20; $i++) {
                if (isset($_POST['Students'][$i]['first_name']) && trim($_POST['Students'][$i]['first_name']) != '') {
                    $model = new Students;
                    $model->attributes = $_POST['Students'][$i];
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
                $this->redirect(array('students/addbulkstudents/aid/' . $aid . '/cid/' . $cid));
            }
        }

        if ($model->dob == "0000-00-00") {
            $model->dob = "";
        }
        if ($model->course_completion_date == "0000-00-00") {
            $model->course_completion_date = "";
        }

        $this->render('addbulkstudents', compact('model'));
    }

    public function actionManagestudents() {
        $model = new DmvClasses;
        $affiliates = DmvAffiliateInfo::all_affliates("Y");

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvClasses']))
            $model->attributes = $_GET['DmvClasses'];

        $this->render('managestudents', compact('model', 'affiliates'));
    }

    public function actionViewstudents($aid, $cid) {
        $model = new Students('search');
        $print_certificate = "N";

        $model->unsetAttributes();  // clear any default values

        $model->affiliate_id = $aid;
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

        $affiliates_arr = DmvAffiliateInfo::all_affliates();
        $firstItem = array('' => '- Select One -');
        $affiliates = $firstItem + $affiliates_arr;
        $classes = array();

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Students'])) {
            $model->attributes = $_POST['Students'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Students Created Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        if ($model->dob == "0000-00-00") {
            $model->dob = "";
        }
        if ($model->course_completion_date == "0000-00-00") {
            $model->course_completion_date = "";
        }

        $this->render('create', compact('model', 'affiliates', 'classes'));
    }

    public function actionGetclasses() {
        $options = '';
        $affid = isset($_POST['id']) ? $_POST['id'] : '';

        /* Using in schedules form and instrucor search */
        //$default_val = isset($_POST['form']) ? "Select One" : 'ALL'; 
        //$default_option_val = isset($_POST['form']) ? "" : '0'; 
        $options = "<option value=''>Select Class</option>";
        if ($affid != '') {
            $data_Classes = DmvClasses::all_classes($affid);
            foreach ($data_Classes as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
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

        if (isset($_POST['Students'])) {
            $model->attributes = $_POST['Students'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Student Updated Successfully!!!');
                $this->redirect(array('students/viewstudents/aid/' . $model->affiliate_id . '/cid/' . $model->clas_id));
            }
        }

        if ($model->course_completion_date == "0000-00-00") {
            $model->course_completion_date = "";
        }

        if ($model->dob == "0000-00-00") {
            $model->dob = "";
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Students('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Students']))
            $model->attributes = $_GET['Students'];

        $this->render('admin', array(
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
    
    public function actionExceldownload(){   
        
        $from_date ='';
        $to_date ='';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['Students'])){            
            $from_date = $_GET['Students']['start_date'];
            $to_date = $_GET['Students']['end_date'];        
        }
        
            $ret_result = Yii::app()->db->createCommand("SELECT dms.student_id AS 'Student ID',dms.affiliate_id AS 'Affiliate ID',dms.clas_id AS 'Class ID',dms.first_name AS 'First Name',
                    dms.middle_name AS 'Middle Name',dms.last_name AS 'Last Name',dms.stud_suffix AS 'Student Suffix',dms.address1 AS 'Address1',dms.address2 AS 'Address2',
                    dms.city AS 'city',dms.state AS 'state',dms.zip AS 'zip',dms.phone AS 'phone',dms.email AS 'email',dms.gender AS 'gender',dms.dob AS 'dob',dms.licence_number AS 'licence_number',
                    dms.notes AS 'Notes',dms.course_completion_date AS 'Course Completion Date',dmc.certificate_number AS 'Certificate Number'
                    FROM dmv_students AS dms LEFT JOIN dmv_print_certificate AS dmc ON dms.student_id = dmc.student_id,dmv_affiliate_info AS dma WHERE dma.affiliate_id = dms.affiliate_id AND dma.admin_id='".$admin_id."' AND dms.course_completion_date >= '".$from_date."' AND dms.course_completion_date <= '".$to_date."'");
            
            $file_name = 'students_' . date('Y-m-d').'.csv';
                  
            Yii::import('ext.ECSVExport');           
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();                   
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
            exit();
//            $this->redirect(array('index'));
    }

}
