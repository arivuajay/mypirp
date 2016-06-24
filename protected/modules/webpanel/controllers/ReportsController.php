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
                'actions' => array('bookorderreport','paymentreport','quarterlyannualreport','monthlyreport','exceldownload_quarterlyannual','exceldownload_monthly'),
                'expression'=> "AdminIdentity::checkAccess('webpanel.reports.{$this->action->id}')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
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
        $this->render('quarterlyannualreport',compact('model'));
    }
    public function actionMonthlyreport() {
        $model = new DmvAddInstructor();
        $this->render('monthlyreport',compact('model'));
    }
    public function actionExceldownload_quarterlyannual(){   
        
        $from_date ='';
        $to_date ='';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['DmvAddInstructor'])){            
            $from_date = $_GET['DmvAddInstructor']['start_date'];
            $to_date = $_GET['DmvAddInstructor']['end_date'];        
        }
        
                
            $ret_result = Yii::app()->db->createCommand("SELECT
            DFI.agency_code AS 'Agency Code',DFI.agency_name AS 'Delivery Agency Name',DMI.ins_first_name AS 'Instructor First Name',DMI.instructor_last_name AS 'Instructor Last Name',
            DFI.addr1 AS 'Agency Address1',DFI.addr2 AS 'Agency Address2',DFI.city AS 'Agency City',DFI.zip AS 'Agency Zip',DFI.phone AS 'Agency Telephone',
            DATE_FORMAT(DMCL.clas_date,'%m/%d/%Y') AS 'Class Date 1',DMCL.start_time AS 'Class 1 Start Time',DMCL.end_time AS  'Class 1 End Time',DATE_FORMAT(DMCL.date2,'%m/%d/%Y') AS 'Class Date 2',DMCL.start_time2 AS 'Class 2 Start Time',DMCL.end_time2 AS 'Class 2 End Time',
            DMCL.location AS 'Class Location',DMCL.loc_addr AS 'Class Address',DMCL.loc_city AS 'Class City',DMCL.zip AS 'Class Zip Code',DMC.country_desc AS 'Class County',DFI.agency_code AS 'Agency Code',DMI.instructor_code AS 'Instructor Code',
            DMCL.show_admin AS 'Class Status',DMI.instructor_client_id AS 'Drivers License Number' 
            FROM dmv_classes DMCL,dmv_add_instructor  DMI, dmv_country DMC, dmv_affiliate_info   DFI    
            WHERE  (DMCL.clas_date  BETWEEN '".$from_date."'  AND '".$to_date."') AND DMCL.instructor_id = DMI.instructor_id AND DMCL.country = DMC.id AND DFI.affiliate_id = DMCL.affiliate_id ORDER BY DFI.agency_code");
           
            
            $file_name = 'montylyreports' . date('Y-m-d').'.csv';
                  
            Yii::import('ext.ECSVExport');           
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();                   
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
            exit();
    }
    public function actionExceldownload_monthly(){   
        
        $from_date ='';
        $to_date ='';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['DmvAddInstructor'])){            
            $from_date = $_GET['DmvAddInstructor']['start_date'];
            $to_date = $_GET['DmvAddInstructor']['end_date'];        
        }
        
                
            $ret_result = Yii::app()->db->createCommand("SELECT
            DFI.agency_code AS 'Agency Code',DFI.agency_name AS 'Delivery Agency Name',DMI.ins_first_name AS 'Instructor First Name',DMI.instructor_last_name AS 'Instructor Last Name',
            DFI.addr1 AS 'Agency Address1',DFI.addr2 AS 'Agency Address2',DFI.city AS 'Agency City',DFI.zip AS 'Agency Zip',DFI.phone AS 'Agency Telephone',
            DATE_FORMAT(DMCL.clas_date,'%m/%d/%Y') AS 'Class Date 1',DMCL.start_time AS 'Class 1 Start Time',DMCL.end_time AS  'Class 1 End Time',DATE_FORMAT(DMCL.date2,'%m/%d/%Y') AS 'Class Date 2',DMCL.start_time2 AS 'Class 2 Start Time',DMCL.end_time2 AS 'Class 2 End Time',
            DMCL.location AS 'Class Location',DMCL.loc_addr AS 'Class Address',DMCL.loc_city AS 'Class City',DMCL.zip AS 'Class Zip Code',DMC.country_desc AS 'Class County',DFI.agency_code AS 'Agency Code',DMI.instructor_code AS 'Instructor Code',
            DMCL.show_admin AS 'Class Status',DMI.instructor_client_id AS 'Drivers License Number' 
            FROM dmv_classes DMCL,dmv_add_instructor  DMI, dmv_country DMC, dmv_affiliate_info   DFI    
            WHERE  (DMCL.clas_date  BETWEEN '".$from_date."'  AND '".$to_date."') AND DMCL.instructor_id = DMI.instructor_id AND DMCL.country = DMC.id AND DFI.affiliate_id = DMCL.affiliate_id ORDER BY DFI.agency_code");
           
            
            $file_name = 'montylyreports' . date('Y-m-d').'.csv';
                  
            Yii::import('ext.ECSVExport');           
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();                   
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
            exit();
    }
    
    
}

