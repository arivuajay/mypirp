<?php

class InstructorsController extends Controller {
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete','getinstructors','exceldownload'),
                'users' => array('@'),
                'expression'=> 'AdminIdentity::checkAdmin()',
            ),           
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $x_aff = array();
        $model = new DmvAddInstructor;
        
        $affiliates_arr = DmvAffiliateInfo::all_affliates();
        $firstItem = array('0' => '- ALL -');
        $affiliates = $firstItem + $affiliates_arr;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvAddInstructor'])) {

            $model->attributes = $_POST['DmvAddInstructor'];
            $model->admin_id = Yii::app()->user->admin_id;
            $model->created_date = date("Y-m-d",time());
            if ($model->save()) {
                $instructor_id = $model->instructor_id;

                // Save affliates for this instructor
                if (isset($model->Affiliate) && !empty($model->Affiliate)) {
                    $aff_array = $model->Affiliate;
                    if (in_array("0", $aff_array)) {
                         $aff_ins = new DmvAffInstructor;
                         $aff_ins->affiliate_id = 0;
                         $aff_ins->instructor_id = $instructor_id;
                         $aff_ins->save();                        
                    } else {
                        foreach ($aff_array as $aff) {
                            $aff_ins = new DmvAffInstructor;
                            $aff_ins->affiliate_id = $aff;
                            $aff_ins->instructor_id = $instructor_id;
                            $aff_ins->save();
                        }
                    }
                }

                Yii::app()->user->setFlash('success', 'Instructor Created Successfully!!!');
                $this->redirect(array('index'));
            }
        }

        if ($model->instructor_dob == "0000-00-00") {
            $model->instructor_dob = "";
        }

        $this->render('create', compact('model', 'affiliates', 'x_aff'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $affiliates_arr = DmvAffiliateInfo::all_affliates();
        $firstItem  = array('0' => '- ALL -');
        $affiliates = $firstItem + $affiliates_arr;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvAddInstructor'])) {
            $model->attributes = $_POST['DmvAddInstructor'];
            if ($model->save()) {
                $instructor_id = $model->instructor_id;
                // Save affliates for this instructor
                if (isset($model->Affiliate) && !empty($model->Affiliate)) {

                    $this->delete_aff_ins($instructor_id);

                    $aff_array = $model->Affiliate;                    
                    //if (count(array_filter($aff_array)) == count($aff_array)) {
                    if (in_array("0", $aff_array)) {
                        $aff_ins = new DmvAffInstructor;
                        $aff_ins->affiliate_id = 0;
                        $aff_ins->instructor_id = $instructor_id;
                        $aff_ins->save();
                    } else {                        
                        foreach ($aff_array as $aff) {
                            $aff_ins = new DmvAffInstructor;
                            $aff_ins->affiliate_id = $aff;
                            $aff_ins->instructor_id = $instructor_id;
                            $aff_ins->save();
                        }
                    }
                }

                Yii::app()->user->setFlash('success', 'Instructor Updated Successfully!!!');
                $this->redirect(array('index'));
            }
        }
        
        /* Selected affliates */
        $ins_aff_list = DmvAffInstructor::get_ins_affliates($id);
        $x_aff = array();
        if (!empty($ins_aff_list)) {
            foreach ($ins_aff_list as $key => $value) {
                $x_aff[$key] = array("selected" => "selected");
            }
        }

        if ($model->instructor_dob == "0000-00-00") {
            $model->instructor_dob = "";
        }

        $this->render('update', compact('model', 'affiliates', 'x_aff'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        
        $this->delete_aff_ins($id);
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Instructor Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }
    
    public function delete_aff_ins($instructor_id = null){          
        $criteria = new CDbCriteria;
        $criteria->condition = "instructor_id= :instructor_id";
        $criteria->params = (array(':instructor_id' => $instructor_id));
        DmvAffInstructor::model()->deleteAll($criteria);
          
        return true;
    } 

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new DmvAddInstructor('search');
        $firstItem = array('0' => '- ALL -');
        $affiliates_arr = DmvAffiliateInfo::all_affliates(); 
        $affiliates = $firstItem + $affiliates_arr;
        
        $instructors_arr = DmvAddInstructor::all_instructors();
        $instructors = $firstItem + $instructors_arr;
        
        
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvAddInstructor']))
            $model->attributes = $_GET['DmvAddInstructor'];

        $this->render('index', compact('model', 'affiliates','instructors'));
    }
    
    public function actiongetinstructors()
    {
        $options = '';       
        $afid = isset($_POST['id']) ? $_POST['id'] : '';   
        
        /* Using in schedules form and instrucor search */
        $default_val = isset($_POST['form']) ? "Select Instructor" : 'ALL'; 
        $default_option_val = isset($_POST['form']) ? "" : '0'; 
        
        if ($afid != '') {   
            $options = "<option value='".$default_option_val."'>".$default_val."</option>";
            $data_instructors = DmvAddInstructor::all_instructors($afid);
            foreach ($data_instructors as $k => $info) {
                $options .= "<option value='" . $k . "'>" . $info . "</option>";
            }
        }
        echo $options;
        exit;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DmvAddInstructor the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DmvAddInstructor::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DmvAddInstructor $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dmv-add-instructor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionExceldownload(){   
        
        $from_date ='';
        $to_date ='';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['DmvAddInstructor'])){            
            $from_date = $_GET['DmvAddInstructor']['start_date'];
            $to_date = $_GET['DmvAddInstructor']['end_date'];        
        }
            $ret_result = Yii::app()->db->createCommand("SELECT instructor_id as 'Instructor ID',instructor_ss as 'Instructor ss',instructor_last_name as 'Last Name',ins_first_name as 'First Name',
                    instructor_initial as 'Initial',instructor_suffix as 'Instructor Suffix',instructor_code as 'Instructor Code',instructor_client_id as 'Client id',instructor_dob as 'Instructor DOB',
                    enabled as 'Enabled',gender as 'Gender',addr1 as 'Address1',addr2 as 'Address2',city as 'City',state as 'State',zip as 'Zip',phone as 'Phone',created_date as 'Created Date'
                    FROM dmv_add_instructor WHERE  admin_id = '".$admin_id."' AND created_date >= '".$from_date."' AND created_date <= '".$to_date."'");
            $file_name = 'instructors_' . date('Y-m-d').'.csv';
                  
            Yii::import('ext.ECSVExport');           
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();                   
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
            exit();
//            $this->redirect(array('index'));
    }

}
