<?php

class LogactivitiesController extends Controller {
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
                'actions' => array('index', 'delete'),
                'users' => array('@'),               
                'expression'=> "SuAdminIdentity::checkAccess('suadmin.logactivities.{$this->action->id}')",
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('success', 'Log deleted Successfully!!!');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new AuditTrail('search');
        $model->unsetAttributes();  // clear any default values
        
        $admininfos = Admin::model()->findAll(array("order" => "username"));
        $adminvals = CHtml::listData($admininfos, 'admin_id', 'username');
        
       
        if (isset($_GET['AuditTrail']))
        {    
            $model->attributes = $_GET['AuditTrail'];            
            if(isset($_GET['deleteacts']) && $_GET['deleteacts']=="Delete")
            {
                $cond = array();
                
                $adminid = $model->admin_id;
                $start_date = $model->start_date;
                $end_date = $model->end_date;
                
                if($adminid!="")
                $cond[] = "admin_id = '$adminid'";    
                
                if($start_date!="" && $end_date!="")
                $cond[] = "DATE(aud_created_date) BETWEEN '$start_date' AND '$end_date'";
                
                if(!empty($cond))
                {
                    $search_conds = implode(" AND ",$cond);                   
                    AuditTrail::model()->deleteAll($search_conds);
                
                    Yii::app()->user->setFlash('success', 'Log activities deleted Deleted Successfully!!!');
                    $this->redirect(array('index'));
                }    
            }    
            
        }    

        $this->render('index', compact('model','adminvals'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Admin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AuditTrail::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Admin $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'audit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
