<?php

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
                'actions' => array('index', 'update', 'view', 'delete','printstudentcertificate','certificatedisplay'),
                'users' => array('@'),
                'expression' => 'AdminIdentity::checkAdmin()',
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
    public function actionPrintstudentcertificate($id) {
        $model = new PrintCertificate('search');
        $class_id=$id;
        
        $classinfo = DmvClasses::model()->findByPk($id);
        $class_info = $classinfo->clas_date. " ".$classinfo->start_time. " To ".$classinfo->end_time;
        
        $this->render('printstudentcertificate', compact('model','class_id','class_info'));
    }
    
    public function actionCertificatedisplay($id) {
        $data['student_id']= $id; 
        echo $this->renderPartial('_certificatedisplay', $data, false, true);
        exit;
    }
    

    public function actionUpdate($id) {
        $model = new PrintCertificate;
        $students = Students::get_student_list($id);
       
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['PrintCertificate'])) {
            
            $model->attributes = $_POST['PrintCertificate'];      
            $student_id = $model->student_id;            
            $class_id   = $id;
            $certificate_number = PrintCertificate::model()->find("class_id=".$class_id." and student_id=".$student_id)->certificate_number;
            
            if($certificate_number!="")
            {    
              $pmodel = PrintCertificate::model()->findByPk($certificate_number);
              $pmodel->attributes = $_POST['PrintCertificate'];
              $pmodel->class_id   = $class_id;
                if ($pmodel->save()) {
                    Yii::app()->user->setFlash('success', 'Notes Updated Successfully!!!');
                    $this->redirect(array('index'));
                }
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
