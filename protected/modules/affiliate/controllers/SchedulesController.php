<?php

class SchedulesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
        public $layout = '//layouts/aff_column1';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
                                'expression'=> 'AffiliateIdentity::checkAffiliate()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            
            $model=new DmvClasses('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DmvClasses']))
			$model->attributes=$_GET['DmvClasses'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        public function checkprintcertificate($clas_id)
        {
            $print_certificate = Payment::model()->find("class_id=".$clas_id)->print_certificate;
            if($print_certificate=='Y') {
                $rval = "Completed";
            }else{
                $rval = "Submitted";
            }
            return $rval;
        }        


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DmvClasses the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DmvClasses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DmvClasses $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='dmv-classes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
