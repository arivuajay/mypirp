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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'addbulkstudents','managestudents','viewstudents','getclasses'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(''),
                'users' => array('admin'),
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

    public function actionManagestudents()
    {
        $model = new DmvClasses;
        $affiliates = DmvAffiliateInfo::all_affliates("Y");
        
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DmvClasses']))
        $model->attributes = $_GET['DmvClasses'];       
        
        $this->render('managestudents', compact('model','affiliates'));
    }  
    
    public function actionViewstudents($aid,$cid)
    {
        $model = new Students('search');
       
        $model->unsetAttributes();  // clear any default values
        
        $model->affiliate_id = $aid;
        $model->clas_id =   $cid;       
                
        if (isset($_GET['Students']))
        $model->attributes = $_GET['Students'];
       
        $this->render('viewstudents', compact('model'));
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

        $this->render('create', compact('model','affiliates','classes'));
    }
    
    public function actionGetclasses()
    {
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
    
    public function all_classes($cid)
    {
        
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
                $this->redirect(array('students/viewstudents/aid/'.$model->affiliate_id.'/cid/'.$model->clas_id));
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

}
