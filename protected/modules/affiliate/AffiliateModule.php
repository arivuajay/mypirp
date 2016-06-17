<?php

class AffiliateModule extends CWebModule
{
    
    public $homeUrl = array('/affiliate/default/index');
    public $layout = '//layouts/aff_main';

    public function init() {
     
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'affiliate.components.*',
        ));
        Yii::app()->theme = 'adminlte';
        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');
        
        Yii::app()->getComponent("booster");

        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => '/affiliate/default/error'),
            'user' => array(
                'class' => 'CWebUser',
                'loginUrl' => array('/affiliate/default/login'),
                'allowAutoLogin' => true,
            )
        ));

        
        Yii::app()->user->setStateKeyPrefix('_affiliate');
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
