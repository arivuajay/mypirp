<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/protected/extensions/html2pdf/vendor/tecnickcom/tcpdf/tcpdf.php');
class PrintcertificateController extends Controller {
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
                'actions' => array('index', 'update', 'view', 'delete', 'printstudentcertificate', 'certificatedisplay', 'pendingcertificates',),
                'expression' => "AdminIdentity::checkAccess('webpanel.printcertificate.{$this->action->id}')",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionPendingcertificates() {
        $model = new DmvClasses();
        $class_infos = array();

        if (isset($_POST['yt1']) && $_POST['yt1'] == "Print Certificate") {

            $classid = $_POST['DmvClasses']['pnewclassid'];

            $stud_count = Students::model()->count("clas_id=" . $classid);

            if ($stud_count > 0) {
                $stud_infos = Students::model()->findAll("clas_id=" . $classid);

                $payment_id = Payment::model()->find("class_id=" . $classid)->payment_id;
                $pmodel = Payment::model()->findByPk($payment_id);
                $pmodel->print_certificate = 'Y';
                $pmodel->save();

                foreach ($stud_infos as $sinfos) {
                    $pc_model = new PrintCertificate;
                    $pc_model->class_id = $classid;
                    $pc_model->student_id = $sinfos->student_id;
                    $pc_model->issue_date = date("Y-m-d", time());
                    $pc_model->save();
                }

                Myclass::addAuditTrail("Certificates generated successfully. Class id - {$classid}", "printcertificate");
                Yii::app()->user->setFlash('success', 'Certificates generated successfully!!');
                $this->redirect(array('printcertificate/printstudentcertificate/id/' . $classid));
            } else {

                $redirecturl = Yii::app()->request->urlReferrer;
                Yii::app()->user->setFlash('danger', 'No students are available for this class!!!');
                $this->redirect($redirecturl);
            }
        }

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvClasses'])) {
            $model->attributes = $_GET['DmvClasses'];
            $agencycode = $model->agencycode;
            $clasdate   = $model->clasdate;
            
            $criteria = new CDbCriteria;
            $criteria->addCondition("Affliate.admin_id='" . Yii::app()->user->admin_id . "'");

            if ($clasdate != "") {
                $clasdate = Myclass::dateformat($clasdate);
                $criteria->addCondition("dmvClasses.clas_date= '" . $clasdate . "'");
            }

            if ($agencycode != "") {
                $criteria->addCondition("Affliate.agency_code='" . $agencycode . "'");
            }

            $criteria->addCondition("payment_complete='Y' and print_certificate='N'");

            $criteria->with = array("dmvClasses", "dmvClasses.Affliate");
            $criteria->together = true;

            $classes_info = Payment::model()->findAll($criteria);

            foreach ($classes_info as $infos) {
                $class_infos[$infos->dmvClasses->clas_id] = $infos->dmvClasses->Affliate->agency_code . " " . date("F d,Y", strtotime($infos->dmvClasses->clas_date)) . " " . $infos->dmvClasses->start_time . " to " . $infos->dmvClasses->end_time;
            }
        }



        $this->render('pendingcertificates', compact('model', 'class_infos'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionPrintstudentcertificate($id) {
       
        $model = new PrintCertificate('search');
        $class_id = $id;
        
        $classinfo = DmvClasses::model()->findByPk($id);
        $class_info = Myclass::date_dispformat($classinfo->clas_date) . " " . $classinfo->start_time . " To " . $classinfo->end_time;        
            
        if (isset($_POST['idList'])) {
            
            $std_ids = implode(",",$_POST['idList']);

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);            
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Cresmo');
            $pdf->SetTitle($class_info);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            //set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            //set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->SetAutoPageBreak(True, PDF_MARGIN_FOOTER);
            // set font
            $pdf->SetFont('times', '', 10);
            
            $sresults_info = Students::model()->with("dmvAffiliateInfo")->findAll("student_id in ($std_ids)");

            if (!empty($sresults_info)) {
            foreach ($sresults_info as $sinfo) {   
                    $html = '';
                    $pdf->AddPage();	
                    $html =  $this->renderPartial('certificate_view', array("sinfo" => $sinfo), true);
                    $pdf->writeHTML($html, true, false, true, false, '');
                }
            }
            $pdf->Output('certificate.pdf', 'I');           
        }


       
        $this->render('printstudentcertificate', compact('model', 'class_id', 'class_info'));
    }

    public function actionCertificatedisplay($id) {
        $data['student_id'] = $id;
        echo $this->renderPartial('_certificatedisplay', $data, false, true);
        exit;
    }

    public function actionUpdate($id) {
        $model = new PrintCertificate;
        $model->scenario = "update";
        $students = Students::get_student_list($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PrintCertificate'])) {

            $model->attributes = $_POST['PrintCertificate'];
            $student_id = $model->student_id;
            $class_id   = Yii::app()->request->getQuery('id');
            
            $certificate_number = PrintCertificate::model()->find("class_id=" . $class_id . " and student_id=" . $student_id)->certificate_number;

            if ($certificate_number != "") {
                $pmodel = PrintCertificate::model()->findByPk($certificate_number);
                $pmodel->attributes = $_POST['PrintCertificate'];
                $pmodel->class_id = $class_id;
              
                if ($pmodel->save()) {
                    Myclass::addAuditTrail("Notes Updated Successfully. Student id - {$student_id}", "printcertificate");
                    
                    $sresults_info = Students::model()->with("dmvAffiliateInfo")->findByPk($student_id);
                           
                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);            
                    $pdf->SetCreator(PDF_CREATOR);
                    $pdf->SetAuthor('Cresmo');
                    $pdf->SetTitle("RePrint");
                    $pdf->setPrintHeader(false);
                    $pdf->setPrintFooter(false);
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                    //set margins
                    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                    //set auto page breaks
                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    //set image scale factor
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                    $pdf->SetAutoPageBreak(True, PDF_MARGIN_FOOTER);
                    // set font
                    $pdf->SetFont('times', '', 10);
                    
                    if (!empty($sresults_info)) {  
                            $html = '';
                            $pdf->AddPage();	
                            $html =  $this->renderPartial('certificate_view', array("sinfo" => $sresults_info), true);
                            $pdf->writeHTML($html, true, false, true, false, '');                       
                    }
                    $pdf->Output('certificate.pdf', 'I');                        
                }
            }else{
                $this->redirect(array('index'));
            }
        }

        $this->render('update', compact('model', 'students'));
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
        Myclass::addAuditTrail("Class deleted successfully.And its related payment,students,certificates also deleted . class_id id - {$id}", "printcertificate");
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Class Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Payment('print_certificate_search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('index', compact('model'));
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'print-certificate-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
