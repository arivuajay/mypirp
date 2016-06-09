<?php

class SuAdminModule extends CWebModule
{
    
    public $homeUrl = array('/suadmin/default/index');
    public $layout = '//layouts/main';

    public function init() {
      
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'webpanel.components.*',
        ));
        Yii::app()->theme = 'suadmin';
        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');
        
        Yii::app()->getComponent("booster");

        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => '/suadmin/default/error'),
            'user' => array(
                'class' => 'CWebUser',
                'loginUrl' => array('/suadmin/default/login'),
                'allowAutoLogin' => true,
            )
        ));

        
        Yii::app()->user->setStateKeyPrefix('_admin');
        Yii::app()->user->loginUrl = Yii::app()->createUrl("/{$this->id}/default/login");
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}