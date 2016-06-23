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
                'actions' => array('bookorderreport','paymentreport'),
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
}
