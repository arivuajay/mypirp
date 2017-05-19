<?php

class SchedulesController extends Controller {

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
                'actions' => array('index', 'uploadschedule'),
                'users' => array('@'),
                'expression' => 'AffiliateIdentity::checkAffiliate()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (isset($_GET['cid'])) {
            $cmodel = DmvClasses::model()->findByAttributes(array('clas_id' => $_GET['cid']));
            $cmodel->show_admin = 'Y';
            $cmodel->pending = '1';
            $cmodel->save();
            if ($cmodel->save()) {
                Yii::app()->user->setFlash('success', 'Submit Class Successfully!!!');
            } else {
                Yii::app()->user->setFlash('error', 'Not Submit Class');
            }

            $this->redirect(array('/affiliate/schedules/index'));
        }
        $model = new DmvClasses('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvClasses']))
            $model->attributes = $_GET['DmvClasses'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function checkprintcertificate($clas_id) {
        $print_certificate = Payment::model()->find("class_id=" . $clas_id)->print_certificate;
        if ($print_certificate == 'Y') {
            $rval = "Completed";
        } else {
            $rval = "Pending";
        }
        return $rval;
    }

    public function actionUploadschedule() {

        $affiliate_id = Yii::app()->user->affiliate_id;
        $affinfos = DmvAffiliateInfo::model()->findByPk($affiliate_id);
        $agency_code = $affinfos->agency_code;
        $agency_name = $affinfos->agency_name;
        $admin_id = $affinfos->admin_id;

        $model = new UploadForm();

        $this->performAjaxValidation($model);

        $upload_path = Yii::getPathOfAlias('webroot') . '/' . XL_PATH_AFF;

        if (isset($_POST['UploadForm'])) {
            if ($model->validate()) {
                $model->scheduledoc = CUploadedFile::getInstance($model, 'scheduledoc');
                if ($model->scheduledoc) {
                    $filename = time() . '_' . $model->scheduledoc->name;
                    $model->scheduledoc->saveAs($upload_path . $filename);

                    // Read the Excelsheet and Insert Schedules to Database
                     $output_data = $this->excelsheetschedules($filename,$affiliate_id,$agency_code,$agency_name,$admin_id);

                    if (isset($output_data['status'])) {

                        if ($output_data['status'] == 1) {
                            Yii::app()->user->setFlash('success', $output_data['message']);
                            $audit_desc = "Scheduled file uploaded by ".$agency_name." (".$agency_code.") and classes imported Successfully. Filename - " . $filename;
                        } else if ($output_data['status'] == 2) {
                            Yii::app()->user->setFlash('danger', $output_data['message']);
                            $audit_desc = $output_data['message'] . " Filename - " . $filename;
                        } else if ($output_data['status'] == 3) {
                            Yii::app()->user->setFlash('info', $output_data['message']);
                            $audit_desc = "Scheduled file uploaded Successfully by ".$agency_name." (".$agency_code.")." . $output_data['message'] . ". Filename - " . $filename;
                        }
                    } else {

                        Yii::app()->user->setFlash('danger', 'Something is wrong!! Please check the updated fields in the excelsheet!!!');
                        $audit_desc = "Schedule file uploaded successfully by ".$agency_name." (".$agency_code.")." . $output_data['message'] . ". Some fields are incorrect. Filename - " . $filename;
                    }

                    Myclass::addAuditTrail($audit_desc, "schedules");

                    $this->redirect(array('index'));
                } else {
                    Yii::app()->user->setFlash('danger', 'Have an error occurred!!!');
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('_upload_schedule', compact('model'));
    }

    public function excelsheetschedules($filename = null,$affiliate_id,$agency_code,$agency_name,$admin_id) {
      
        $result = array();
        $tot_schedules_inserted = 0;
        $existing_schedules = 0;
        $pblm_schedules = 0;

        $fpath = Yii::getPathOfAlias('webroot') . '/' . XL_PATH_AFF . $filename;

        if (file_exists($fpath)) {

            Yii::import('ext.phpexcelreader.JPhpExcelReader');
            $data = new JPhpExcelReader($fpath);

            $rows = $data->rowcount(); // 
            $cols = $data->colcount(); // 10

            for ($i = 2; $i <= $rows; $i++) {

                for ($j = 1; $j <= $cols; $j++) {
//                    if ($j == 1) {
//                        $affiliate_code = $data->val($i, $j);
//                    } else 
                    if ($j == 1) {
                        $instructor_code = $data->val($i, $j);
                    } else if ($j == 2) {
                        // $schedule_date = strtotime(str_replace('/', '-', $data->val($i, $j)));
                        // $schedule_date = date('Y-m-d', $schedule_date);

                        $schedule_date = $data->val($i, $j);
                        $schedule_date = date("Y-m-d", strtotime($schedule_date));

//                        $exp_dte = explode('/', $schedule_date);
//                        $smonth = $exp_dte[0];
//                        $sdate = $exp_dte[1];
//                        $syear = $exp_dte[2];
//                        $schedule_date = $sdate . "-" . $smonth . "-" . $syear;
                    } else if ($j == 3) {
                        $start_time = $data->val($i, $j);
                    } else if ($j == 4) {
                        $end_time = $data->val($i, $j);
                    } else if ($j == 5) {
                        $location = $data->val($i, $j);
                    } else if ($j == 6) {
                        $location_addr = $data->val($i, $j);
                    } else if ($j == 7) {
                        $city = $data->val($i, $j);
                    } else if ($j == 8) {
                        $state = $data->val($i, $j);
                    } else if ($j == 9) {
                        $zip = $data->val($i, $j);
                    } else if ($j == 10) {
                        $country_code = $data->val($i, $j);
                    }
                }
//echo $instructor_code;
                $instructor_id = DmvAddInstructor::model()->find("instructor_code = :x_instructor_code and admin_id = :x_admin_id", array(':x_instructor_code' => $instructor_code, ':x_admin_id' => $admin_id))->instructor_id;
                $country_id = DmvCountry::model()->find("country_code = :x_country_code", array(':x_country_code' => $country_code))->id;
//
//                echo "Aff".$affiliate_id.'<br>' ;
//                echo "schedule_date".$schedule_date.'<br>' ;
//                echo "start_time".$start_time.'<br>' ;
//                 echo "end_time".$end_time.'<br>' ;
//                  echo "instructor_id".$instructor_id.'<br>' ;
//                     exit;
                if ($affiliate_id != "" && $schedule_date != "" && $start_time != "" && $end_time != "" && $instructor_id != "") {

                    /* Insert record in AffInstructor Table */
                    $chckcondition = "affiliate_id='" . $affiliate_id . "' and instructor_id='" . $instructor_id . "'";
                    $aff_ins_exist = DmvAffInstructor::model()->count($chckcondition);
                    if ($aff_ins_exist == 0) {
                        $aimodel = new DmvAffInstructor;
                        $aimodel->affiliate_id = $affiliate_id;
                        $aimodel->instructor_id = $instructor_id;
                        $aimodel->save();
                    }

                    $condition = "affiliate_id='" . $affiliate_id . "' and  clas_date='" . $schedule_date . "' and start_time='" . $start_time . "' and end_time='" . $end_time . "' and instructor_id='" . $instructor_id . "'";
//           echo $condition; echo "<br>";
                    $scheduleexist = DmvClasses::model()->count($condition);
                    if ($scheduleexist == 0) {
                        /* Insert record in Classes Table */
                        $smodel = new DmvClasses;
                        $smodel->affiliate_id = $affiliate_id;
                        $smodel->clas_date = $schedule_date;
                        $smodel->start_time = $start_time;
                        $smodel->end_time = $end_time;
                        $smodel->location = $location;
                        $smodel->loc_addr = $location_addr;
                        $smodel->loc_city = $city;
                        $smodel->loc_state = $state;
                        $smodel->zip = $zip;
                        $smodel->country = $country_id;
                        $smodel->instructor_id = $instructor_id;
                        $smodel->show_admin = "Y";
                        if($smodel->save()){
                           $audit_desc = date("F d,Y", strtotime($smodel->clas_date)) . " " . $smodel->start_time . " to " . $smodel->end_time . " Class id - {$smodel->clas_id} ";
                           Myclass::addAuditTrail("Schedules {$audit_desc} created by ".$agency_name." (".$agency_code.") successfully.", "schedules");

                           $tot_schedules_inserted++;
                        }else{
                            $pblm_schedules++;
                        }
                    }else {
                        $existing_schedules++;
                    }
                }
            }
            
             // Without header
            $tot_rows = $rows - 1;
//echo 'TR='.$tot_rows.'<br>';
//echo 'TSI='.$tot_schedules_inserted.'<br>';
//echo 'ES='.$existing_schedules.'<br>';
//echo 'PS='.$pblm_schedules.'<br>';
            if ($tot_rows == $tot_schedules_inserted) {
                $result['inserted_count'] = $tot_schedules_inserted;
                $result['existing_count'] = 0;
                $result['message'] = $tot_schedules_inserted . ' Classes are Created Successfully!!!';
                $result['status'] = 1;
            } else if ($tot_rows == $existing_schedules) {
                $result['inserted_count'] = 0;
                $result['existing_count'] = $existing_schedules;
                $result['message'] = 'Uploaded classes already exists!!!';
                $result['status'] = 2;
            } else if ($existing_schedules > 0 && $tot_schedules_inserted > 0) {
                $msg = "";
                $result['inserted_count'] = $tot_schedules_inserted;
                $result['existing_count'] = $existing_schedules;
                if($pblm_schedules>0)
                    $msg = " And some schedules (".$pblm_schedules.") have problem to inserted in database!!!";
                    
                $result['message'] = $tot_schedules_inserted . ' Classes are Created Successfully and ' . $existing_schedules . ' Classes are already exists!!!'.$msg;
                $result['status'] = 3;
            }
//            echo "<pre>";
//            print_r($result); exit;
            
        }

        return $result;
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
