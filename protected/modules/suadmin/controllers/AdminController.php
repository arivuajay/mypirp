<?php

class AdminController extends Controller {
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
        $model = new Admin;

        $all_resourses = DmvResources::model()->findAll('parent_id=0');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];

            $domainname = str_replace("http://","",$model->domain_url);
            $sitename = explode(".",$domainname);
            if($sitename[0] != 'www')
            {
                $addwww = implode(".",$sitename);
                $model->domain_url = 'http://www.'.$addwww;
            }

            if ($model->validate())
            {
                $model->password = Myclass::refencryption($model->password);
                if ($model->save()) {
                    $resource_key = $_POST['resource_key'];
                    if (isset($resource_key)) {
                        $criteria = new CDbCriteria;
                        $criteria->condition = "admin_id= :adminid";
                        $criteria->params = (array(':adminid' => $model->admin_id));
                        DmvAdminResources::model()->deleteAll($criteria);
                        foreach ($resource_key as $rid) {
                            $adminres = new DmvAdminResources;
                            $adminres->admin_id = $model->admin_id;
                            $adminres->resource_key = $rid;
                            $adminres->save();
                        }
                    }

                    Yii::app()->user->setFlash('success', 'Admin Created Successfully!!!');
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'resources' => $all_resourses
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $all_resourses = DmvResources::model()->findAll('parent_id=0');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Admin'])) {
           $model->attributes = $_POST['Admin'];

            $domainname = str_replace("http://", "", $model->domain_url);
            $sitename = explode(".", $domainname);
            if ($sitename[0] != 'www') {
                $addwww = implode(".", $sitename);
                $model->domain_url = 'http://www.' . $addwww;
            }

            if ($model->validate())
            {
                $model->password = Myclass::refencryption($model->password);
                if ($model->save(false)) {

                    $resource_key = $_POST['resource_key'];
                    if (isset($resource_key)) {
                        $criteria = new CDbCriteria;
                        $criteria->condition = "admin_id= :adminid";
                        $criteria->params = (array(':adminid' => $model->admin_id));
                        DmvAdminResources::model()->deleteAll($criteria);
                        foreach ($resource_key as $rid) {
                            $adminres = new DmvAdminResources;
                            $adminres->admin_id = $model->admin_id;
                            $adminres->resource_key = $rid;
                            $adminres->save();
                        }
                    }

                    Yii::app()->user->setFlash('success', 'Admin Updated Successfully!!!');
                    $this->redirect(array('index'));
                }
            }
        }

        $criteria = new CDbCriteria;
        $criteria->condition = "admin_id= :adminid";
        $criteria->params = (array(':adminid' => $id));
        $adminres = DmvAdminResources::model()->findAll($criteria);
        $resArr = CHtml::listData($adminres, 'adres_id', 'resource_key');


        $model->password = Myclass::refdecryption($model->password);
        $this->render('update', array(
            'model' => $model,
            'resources' => $all_resourses,
            'existing_resource' => $resArr
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
            Yii::app()->user->setFlash('success', 'Admin Deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Admin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Admin']))
            $model->attributes = $_GET['Admin'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Admin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Admin::model()->findByPk($id);
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
