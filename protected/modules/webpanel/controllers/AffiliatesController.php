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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete','exceldownload'),
                'expression'=> "AdminIdentity::checkAccess('webpanel.affliates.{$this->action->id}')",
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
        $model->scenario = "create";
        
        $refmodel = new DmvAffiliateCommission;

        $model->unsetAttributes();  // clear any default values
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if (isset($_POST['DmvAffiliateInfo'])) {
            $model->attributes = $_POST['DmvAffiliateInfo'];
            $refmodel->attributes = $_POST['DmvAffiliateCommission'];

            $valid = $model->validate();
            $valid = $refmodel->validate() && $valid;
            if ($valid) {
                $model->agency_approved_date = ($model->agency_approved_date!="")?Myclass::dateformat($model->agency_approved_date):"";
                $model->aff_created_date = date("Y-m-d",time());
                $model->sponsor_code = "28";
                $model->file_type    = "QTR";
                $model->record_type  = "A";
                $model->trans_type   = "X";
                $model->admin_id = Yii::app()->user->admin_id;
                if ($model->save()) {
                    Myclass::addAuditTrail("{$model->agency_code} - {$model->agency_name} affiliate created successfully. Aff id - {$model->affiliate_id}", "affiliates");
                    
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
        $model->scenario = "update";

        $refmodel = DmvAffiliateCommission::model()->find("affiliate_id=" . $model->affiliate_id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['DmvAffiliateInfo'])) {
            $model->attributes = $_POST['DmvAffiliateInfo'];
            $refmodel->attributes = $_POST['DmvAffiliateCommission'];

            $valid = $model->validate();
            $valid = $refmodel->validate() && $valid;
            if ($valid) {
                $model->agency_approved_date = ($model->agency_approved_date!="")?Myclass::dateformat($model->agency_approved_date):"";
                if ($model->save()) {
                    Myclass::addAuditTrail("{$model->agency_code} - {$model->agency_name} affiliate updated successfully. Aff id - {$model->affiliate_id}", "affiliates");
                    $refmodel->affiliate_id = $model->affiliate_id;
                    $refmodel->save();
                    Yii::app()->user->setFlash('success', 'Affiliate Info Updated Successfully!!!');
                    $this->redirect(array('index'));
                }
            }    
        }
        
        if($model->agency_approved_date == "0000-00-00")
        {
            $model->agency_approved_date = "";
        }else{
            $model->agency_approved_date = Myclass::date_dispformat($model->agency_approved_date);
        }    

        $this->render('update', compact('model', 'refmodel'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
	
        DmvAffInstructor::model()->deleteAllByAttributes(array("affiliate_id" => $id));
        BookOrders::model()->deleteAllByAttributes(array("affiliate_id" => $id));
        DmvClasses::model()->deleteAllByAttributes(array("affiliate_id" => $id));
        LeadersGuide::model()->deleteAllByAttributes(array("affiliate_id" => $id));
        Students::model()->deleteAllByAttributes(array("affiliate_id" => $id));
        DmvAffiliateCommission::model()->deleteAllByAttributes(array("affiliate_id" => $id));
        
        $model = $this->loadModel($id);
        Myclass::addAuditTrail("{$model->agency_code} - {$model->agency_name} affiliate deleted successfully. Aff id - {$model->affiliate_id}", "affiliates");        
        $model->delete();

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
    public function actionExceldownload(){   
        
        $from_date ='';
        $to_date ='';
        $admin_id = Yii::app()->user->getId();
        if (isset($_GET['DmvAffiliateInfo'])){            
            $from_date = Myclass::dateformat($_GET['DmvAffiliateInfo']['start_date']);
            $to_date = Myclass::dateformat($_GET['DmvAffiliateInfo']['end_date']);                
        }
            $sql = "SELECT ai.affiliate_id as 'Agency ID',ai.agency_code as 'Agency Code',ai.agency_name as 'Agency Name',ai.user_id as 'User Name',
                    ai.password as 'Password',ai.enabled as 'Enabled',ai.aff_created_date as 'Created Date',ai.sponsor_code as 'Sponsor Code',ai.file_type as 'File Type',ai.email_addr as 'Email Address',
                    ai.record_type as 'Record Type',ai.trans_type as 'Trans Type',ai.ssn as 'SSN',ai.fedid as 'Fedid',ai.addr1 as 'Address1',ai.addr2 as 'Address2',ai.city as 'City',ai.state as 'State',ai.zip as 'Zip',
                    ai.country_code as Country_Code,ai.last_name as Last_Name,ai.first_name as First_Name,ai.initial as Initial,ai.contact_suffix as Contact_Suffix,ai.con_title as Con_Title,ai.phone as Phone,
                    ai.phone_ext as 'Phone Ext',ai.fax as 'Fax',ai.owner_last_name as 'Owner Last Name',ai.owner_first_name as 'Owner First Name',ai.owner_initial as 'Owner Initial',ai.owner_suffix as 'Owner Suffix',ai.agency_approved_date as 'Agency Approved Date',
                    ac.commission_id as 'Commission Id',ac.student_fee as 'student Fee',ac.aff_book_fee as 'Book Fee',ac.referral_code as 'Referral Code',ac.referral_amt as 'Referral Amount'
                    FROM dmv_affiliate_info as ai, dmv_affiliate_commission as ac WHERE  ai.affiliate_id = ac.affiliate_id AND ai.admin_id = '".$admin_id."' AND ai.aff_created_date >= '".$from_date."' AND ai.aff_created_date <= '".$to_date."'";
            
            $ret_result = Myclass::getsqlcommand($sql);
            
            $file_name = 'affiliates_' . date('m-d-Y').'.csv';
                  
            Yii::import('ext.ECSVExport');           
            $csv = new ECSVExport($ret_result);
            $content = $csv->toCSV();                   
            Yii::app()->getRequest()->sendFile($file_name, $content, "text/csv", false);
            exit();
        }

}
