<?php

class ReportsController extends Controller {
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
                'actions' => array('bookorderreport', 'certificatereport', 'paymentreport', 'quarterlyannualreport', 'monthlyreport', 'studentcompletionreport', 'duplicates', 'printlabels', 'referralreport'),
                'expression' => "AdminIdentity::checkAccess('webpanel.reports.{$this->action->id}')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionCertificatereport() {
        $model = new PrintCertificate;

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PrintCertificate'])) {
            $model->attributes = $_GET['PrintCertificate'];
        }

        $this->render('certificatereport', compact('model'));
    }

    public function actionBookorderreport() {
        $model = new BookOrders;
        $affiliates = DmvAffiliateInfo::all_affliates("Y");

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BookOrders']))
            $model->attributes = $_GET['BookOrders'];

        $this->render('bookorderreport', compact('model', 'affiliates'));
    }

    public function actionPaymentreport() {
        $model = new Payment;
        $affiliates = DmvAffiliateInfo::all_affliates("Y");

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('paymentreport', compact('model', 'affiliates'));
    }

    public function actionQuarterlyannualreport() {
        $model = new DmvAddInstructor();
        $quarterlyannual = '';
        $from_date = '';
        $to_date = date("Y-m-d");
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['DmvAddInstructor'])) {

            $quarterlyannual = $_GET['DmvAddInstructor']['quarterlyannual'];
            if ($quarterlyannual == 'Quarterly') {
                $from_date = date("Y-m-d", strtotime("-3 Months"));
            } else if ($quarterlyannual == 'Annual') {
                $from_date = date("Y-m-d", strtotime("-12 Months"));
            }

            $sql = "SELECT DFI.agency_code AS 'Agency Code',DMI.instructor_code AS 'Instructor Code',DMC.country_desc AS 'County of Delivery Agency',DFI.agency_name AS 'Delivery Agency Name',
                    CONCAT(DFI.addr1,',',DFI.addr2) AS 'Agency Address' , DFI.city AS 'Agency City',DFI.state AS 'State',DFI.zip AS 'Agency Zip Code',
                    DFI.first_name AS 'Agency Contact Person First Name',DFI.last_name AS 'Agency Contact Person Last Name',DFI.con_title AS 'Agency Contact Person Title',
                    DFI.phone AS 'Agency Telephone #',DFI.fax AS 'Agency Fax #',DFI.agency_approved_date AS 'Date Agency was Approved by Sponsor',DFI.fedid AS 'Agency Fed Tax ID # or SS #',
                    DMI.ins_first_name AS 'Instructor Legal First Name',DMI.instructor_initial AS 'Instructor Legal Middle Name',DMI.instructor_last_name AS 'Instructor Legal Last Name',DMI.instructor_ss AS 'Instructor SS#',DMI.instructor_dob AS 'Instructor DOB',DMI.gender AS 'Instructor Gender',
                    DMI.instructor_client_id AS 'Instructor Client ID (9-digit NYS DL #)',CONCAT(DMI.addr1,',',DMI.addr2) AS 'Instructor Home Address',DMI.city AS 'Instructor City',DMI.state AS 'Instructor State',DMI.zip AS 'Instructor Zip Code',DMI.phone AS 'Instructor Home Phone #'
                FROM dmv_aff_instructor DMAI, dmv_add_instructor  DMI,dmv_affiliate_info   DFI, dmv_country DMC   
                WHERE DFI.admin_id = '" . $admin_id . "' AND (DFI.aff_created_date  BETWEEN '" . $from_date . "'  AND '" . $to_date . "') AND DMAI.instructor_id = DMI.instructor_id AND DFI.country_code = DMC.id AND DFI.affiliate_id = DMAI.affiliate_id";

            $ret_result = Myclass::getsqlcommand($sql);
            $file_name = $quarterlyannual . date('F-d-Y') . '.csv';

            Yii::import('ext.ECSVExport');
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
        }
        $this->render('quarterlyannualreport', compact('model'));
    }

    public function actionMonthlyreport() {
        $model = new DmvAddInstructor();
        $from_date = '';
        $to_date = '';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['DmvAddInstructor'])) {
            $from_date = Myclass::dateformat($_GET['DmvAddInstructor']['start_date']);
            $to_date = Myclass::dateformat($_GET['DmvAddInstructor']['end_date']);

            $sql = "SELECT
                DFI.agency_code AS 'Agency Code',DFI.agency_name AS 'Delivery Agency Name',DMI.ins_first_name AS 'Instructor First Name',DMI.instructor_last_name AS 'Instructor Last Name',
                CONCAT(DFI.addr1,',',DFI.addr2) AS 'Agency Address',DFI.city AS 'Agency City',DFI.zip AS 'Agency Zip',DFI.phone AS 'Agency Telephone',
                DATE_FORMAT(DMCL.clas_date,'%m/%d/%Y') AS 'Class Date 1',DMCL.start_time AS 'Class 1 Start Time',DMCL.end_time AS  'Class 1 End Time',DATE_FORMAT(DMCL.date2,'%m/%d/%Y') AS 'Class Date 2',DMCL.start_time2 AS 'Class 2 Start Time',DMCL.end_time2 AS 'Class 2 End Time',
                DMCL.location AS 'Class Location',DMCL.loc_addr AS 'Class Address',DMCL.loc_city AS 'Class City',DMCL.zip AS 'Class Zip Code',DMC.country_desc AS 'Class County',DFI.agency_code AS 'Agency Code',DMI.instructor_code AS 'Instructor Code',
                DMCL.show_admin AS 'Class Status',DMI.instructor_client_id AS 'Drivers License Number' 
                FROM dmv_classes DMCL,dmv_add_instructor  DMI, dmv_country DMC, dmv_affiliate_info   DFI    
                WHERE DFI.admin_id = '" . $admin_id . "' AND (DMCL.clas_date  BETWEEN '" . $from_date . "'  AND '" . $to_date . "') AND DMCL.instructor_id = DMI.instructor_id AND DMCL.country = DMC.id AND DFI.affiliate_id = DMCL.affiliate_id ORDER BY DFI.agency_code";

            $ret_result = Myclass::getsqlcommand($sql);
            $file_name = 'montylyreports' . date('F-d-Y') . '.csv';

            Yii::import('ext.ECSVExport');
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
        }
        $this->render('monthlyreport', compact('model'));
    }

    public function actionStudentcompletionreport() {
        $model = new Students();
        $from_date = '';
        $to_date = '';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['Students'])) {

            $from_date = Myclass::dateformat($_GET['Students']['start_date']);
            $to_date = Myclass::dateformat($_GET['Students']['end_date']);
            $sql = "SELECT DMS.licence_number, DMS.first_name,DMS.middle_name,DMS.last_name,dob as PDATE,DMS.gender,course_completion_date as CDATE,DMS.affiliate_id,agency_code,DMC.instructor_id,instructor_client_id  
                    from  dmv_students DMS  
                    inner join dmv_affiliate_info DFI on DMS.affiliate_id=DFI.affiliate_id
                    inner join dmv_classes  DMC on DMS.clas_id =DMC.clas_id 
                    inner join dmv_add_instructor DMI on DMC.instructor_id =DMI.instructor_id 
                    where  DFI.admin_id = '" . $admin_id . "' and (course_completion_date  between '$from_date' and '$to_date') 
                    order by student_id";
            $command = Myclass::getsqlcommand($sql);
            $rowCount = $command->execute(); // execute the non-query SQL
            $dataReader = $command->query(); // execute a query SQL

            $data = "";
            $cr = "\r\n";
            $cr1 = "\t";
            if ($rowCount > 0) {
                foreach ($dataReader as $InsArr) {

                    $row_data = "";
                    $name = "";
                    $dob = "000000";
                    $course_completion_date = "00000";
                    $stdname = array();

                    $first_name = isset($InsArr["first_name"]) ? trim($InsArr["first_name"]) : "";
                    $middle_name = isset($InsArr["middle_name"]) ? trim($InsArr["middle_name"]) : "";
                    $last_name = isset($InsArr["last_name"]) ? trim($InsArr["last_name"]) : "";

                    if ($last_name != "") {
                        $stdname[] = $last_name;
                    }
                    if ($first_name != "") {
                        $stdname [] = $first_name;
                    }
                    if ($middle_name != "") {
                        $stdname [] = $middle_name;
                    }
                    if (!empty($stdname))
                        $name = implode(",", $stdname);

                    $name = $this->add_pad($name, 20);
                    ///1 to 20
                    $row_data .= $name;

                    $datebirth = isset($InsArr["PDATE"]) ? $InsArr["PDATE"] : "";
                    if ($datebirth != "") {
                        list($dyear, $dmonth, $ddate) = split("-", $datebirth);
                        $dyr = substr($dyear, -2);
                        $dob = $dmonth . $ddate . $dyr;
                    }

                    ///21 to 26	
                    $row_data .= $dob;

                    ///27
                    $gender = (isset($InsArr["gender"]) && $InsArr["gender"] != "") ? $InsArr["gender"] : "-";
                    $row_data .= $gender;

                    //28 to 49
                    $row_data .= str_repeat(" ", 22);

                    $coursecompletiondate = isset($InsArr["CDATE"]) ? $InsArr["CDATE"] : "";
                    if ($coursecompletiondate != "") {
                        list($cyear, $cmonth, $cdate) = split("-", $coursecompletiondate);
                        $course_comp_yr = substr($cyear, 3);
                        $course_completion_date = $course_comp_yr . $cmonth . $cdate;
                    }

                    ///50 to 54
                    $row_data .= $course_completion_date;

                    //55 to 56
                    $row_data .= "28";

                    $agency_code = isset($InsArr["agency_code"]) ? $InsArr["agency_code"] : "";
                    $agency_code = $this->add_pad($agency_code, 3);
                    /// 57 to 59
                    $row_data .= $agency_code;

                    // 60 to 61
                    $row_data .= str_repeat("0", 2);

                    //62 to 66
                    $row_data .= str_repeat(" ", 5);


                    $licence_number = isset($InsArr["licence_number"]) ? $InsArr["licence_number"] : "";
                    $licence_number = ($licence_number != "") ? $this->add_pad($licence_number, 9) : str_repeat(" ", 9);

                    ///67 to 75
                    $row_data .= $licence_number;

                    ///76
                    $row_data .= "C";

                    /// 77 to 80
                    $row_data .= str_repeat(" ", 4);

                    //add all row to main data
                    $data .= $row_data . $cr;
                }

                $file_name = 'Studentcompletionreport-' . date('F-d-Y') . '.txt';

                header("Content-type: plain/text");
                header("Cache-Control: no-store, no-cache");
                header("Pragma: no-cache");
                header("Expires: 0");
                header('Content-Disposition: attachment; filename="' . $file_name . '"');

                $fp = fopen('php://output', 'a'); // $fp is now the file pointer to file $filename
                if ($fp) {
                    fwrite($fp, $data);    //    Write information to the file
                    fclose($fp);  //    Close the file
                }
                exit;
            } else {
                Yii::app()->user->setFlash('danger', 'No records found!!!');
                $this->redirect(array('studentcompletionreport'));
            }
        }
        $this->render('studentcompletionreport', compact('model'));
    }

    public function add_pad($str, $length, $char = " ") {
        if (strlen($str) > $length) {
            $str_new = substr($str, 0, $length);
        } elseif (strlen($str) < $length) {
            $str_new = str_pad($str, $length, $char, STR_PAD_RIGHT);
        } else {
            $str_new = $str;
        }
        return ($str_new);
    }

    public function actionDuplicates() {
        $admin_id = Yii::app()->user->getId();
        $sql = "SELECT DMS.first_name as 'First Name', DMS.last_name as 'Last Name', DMS.zip as 'Zip', count(DMS.student_id) as 'No of Duplicates' 
               FROM dmv_students DMS, dmv_affiliate_info   DFI WHERE DFI.admin_id = '" . $admin_id . "' AND DFI.affiliate_id = DMS.affiliate_id  GROUP BY DMS.first_name, DMS.last_name, DMS.zip HAVING  count(DMS.student_id)>1 order by DMS.first_name";
        $ret_result = Myclass::getsqlcommand($sql);
        $file_name = 'duplicates' . date('F-d-Y') . '.csv';

        Yii::import('ext.ECSVExport');
        $csv = new ECSVExport($ret_result);
        $content = $csv->toCSV();
        Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
        exit();
    }

    public function actionPrintlabels() {
        $model = new Students();
        $affiliates = DmvAffiliateInfo::all_affliates("Y");

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Students'])) {
            $model->attributes = $_GET['Students'];

            $startdate = Myclass::dateformat($model->startdate);
            $enddate = Myclass::dateformat($model->enddate);

            $affiliate_id = $model->affiliate_id;

            $criteria = new CDbCriteria;
            $criteria->addCondition('t.first_name != ""');

            if ($startdate != "" && $enddate != "")
                $criteria->addCondition("course_completion_date >= '" . $startdate . "' AND course_completion_date <= '" . $enddate . "'");

            if ($affiliate_id)
                $criteria->addCondition('t.affiliate_id = ' . $affiliate_id);

            if ($model->agencycode != "")
                $criteria->addCondition("dmvAffiliateInfo.agency_code = '" . $model->agencycode . "'");


            if ($model->agencyname != "")
                $criteria->compare('dmvAffiliateInfo.agency_name', $model->agencyname, true);

            $criteria->with = array("dmvAffiliateInfo");
            $criteria->together = true;

            $criteria->order = 't.first_name asc';

            $std_infos = Students::model()->findAll($criteria);

            if (!empty($std_infos)) {
                $html2pdf = Yii::app()->ePdf->HTML2PDF();
                $html2pdf->WriteHTML($this->renderPartial('printlabel_view', array("std_infos" => $std_infos), true));
                $html2pdf->Output(time() . ".pdf", EYiiPdf::OUTPUT_TO_DOWNLOAD);
                //$html2pdf->Output();

//                Yii::import('ext.pdflabel.*');
//                $pdf = new PDF_Label('5160', 'mm', 1, 1);
//                $pdf->Open();
               // $pdf->AddPage();

//                foreach ($std_infos as $infos) {
//                    
//                  
//                    $std_address = array();
//
//                    $std_name = $infos->first_name." ".$infos->last_name;
//
//                    $std_address[] = $infos->address1;
//                    $std_address[] = $infos->address2;
//                    $final_address = array_filter($std_address);
//                    $std_add_info = implode(",", $final_address);
//
//                    $std_city  = $infos->city;
//                    $std_state = $infos->state;
//                    $std_zip   = $infos->zip;
//                    
//                    $pdf->Add_PDF_Label(sprintf("%s\n%s\n%s, %s, %s", $std_name, $std_add_info, $std_city, $std_state, $std_zip));
//                }
//                
//                $pdf->Output("Lables-".time(),"D");               
                
            } else {
                Yii::app()->user->setFlash('danger', 'No records found!!!');
                $this->redirect(array('printlabels'));
            }
        }

        $this->render('printlabel', compact('model', 'affiliates'));
    }

    public function actionReferralreport() {
        $model = new Payment();

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
        }

        if (isset($_GET['listperpage']) && $_GET['listperpage'] != '') {
            $listperpage = $_GET['listperpage'];
        } else {
            $listperpage = 100;
        }

        $model->listperpage = $listperpage;

        $criteria = new CDbCriteria();
        $criteria->distinct = true;
        $criteria->condition = "affiliateInfo.admin_id=" . Yii::app()->user->admin_id;
        $criteria->select = 'referral_code';
        $criteria->with = array('affiliateInfo');
        $commis_res = DmvAffiliateCommission::model()->findAll($criteria);
        $refcodes = CHtml::listData($commis_res, 'referral_code', 'referral_code');

        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('referralreport', compact('model', 'refcodes'));
    }

}
