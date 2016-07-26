<?php

class SubadminController extends Controller {
    //public $layout = '//layouts/column2';
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
                'actions' => array('index', 'create', 'update', 'delete'),
                'users' => array('@'),
                'expression'=> 'SuAdminIdentity::checkAdmin()',
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SuAdmin;

        $resourses = DmvSresources::model()->findAll('parent_id=0');
      

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SuAdmin'])) {
            $model->attributes = $_POST['SuAdmin'];

            if ($model->validate())
            {
                $model->password = Myclass::refencryption($model->password);
                if ($model->save()) {
                    $resource_key = $_POST['resource_key'];
                  
                    if (isset($resource_key)) {
                        $criteria = new CDbCriteria;
                        $criteria->condition = "suadmin_id= :adminid";
                        $criteria->params = (array(':adminid' => $model->id));
                        DmvSuadminSresources::model()->deleteAll($criteria);
                        foreach ($resource_key as $rid) {
                            $adminres = new DmvSuadminSresources;
                            $adminres->suadmin_id = $model->id;
                            $adminres->resource_key = $rid;
                            $adminres->save();
                        }
                    }

                    Yii::app()->user->setFlash('success', 'Sub Admin Created Successfully!!!');
                    $this->redirect(array('index'));
                }
            }
        }
 
        $this->render('create', compact('model','resourses'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
       $model = $this->loadModel($id);

       $resourses = DmvSresources::model()->findAll('parent_id=0');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SuAdmin'])) {
           $model->attributes = $_POST['SuAdmin'];

           if ($model->validate())
            {
                $model->password = Myclass::refencryption($model->password);
                if ($model->save(false)) {

                    $resource_key = $_POST['resource_key'];
                   
                    DmvSuadminSresources::model()->deleteAll("suadmin_id=".$model->id);
                    if (isset($resource_key)) {                       
                        foreach ($resource_key as $rid) {
                            $adminres = new DmvSuadminSresources;
                            $adminres->suadmin_id = $model->id;
                            $adminres->resource_key = $rid;
                            $adminres->save();
                        }
                    }
                    
                    $redirecturl = Yii::app()->request->urlReferrer;
                    Yii::app()->user->setFlash('success', 'Sub Admin Updated Successfully!!!');
                    $this->redirect($redirecturl);
                }
            }
        }

        $criteria = new CDbCriteria;
        $criteria->condition = "suadmin_id= :adminid";
        $criteria->params = (array(':adminid' => $id));
        $adminres = DmvSuadminSresources::model()->findAll($criteria);
        $existing_resource = CHtml::listData($adminres, 'adres_id', 'resource_key');


        $model->password = Myclass::refdecryption($model->password);
        
        $this->render('update', compact('model','resourses', 'existing_resource' ));
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
            Yii::app()->user->setFlash('success', 'SuAdmin Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new SuAdmin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SuAdmin']))
            $model->attributes = $_GET['SuAdmin'];

        $this->render('index', compact('model'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Admin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SuAdmin::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Admin $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
