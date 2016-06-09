<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $flashMessages = array();
    public $themeUrl = '';
    public $title = '';
    public $lang = "en";

    public function init() {
        parent::init();

        CHtml::$errorSummaryCss = 'alert alert-danger';

        $this->flashMessages = Yii::app()->user->getFlashes();
        $this->themeUrl = Yii::app()->theme->baseUrl;
        
        $app = Yii::app();
        if (isset($_POST['_lang'])) {
            $app->language = $_POST['_lang'];
            $app->session['_lang'] = $app->language;
            Yii::app()->session['language'] = $app->language;
            $this->refresh();
        } else if (isset($app->session['_lang'])) {
            $app->language = $app->session['_lang'];
            Yii::app()->session['language'] = $app->language;
        } else {
            $app->language = 'en';
            Yii::app()->session['language'] = $app->language;
        }
    }

    public function accessRules() {        
    }

    public function __construct($id, $module = null) {
        
        if (empty(Yii::app()->session['language'])) {
            Yii::app()->language = 'en';
            Yii::app()->session['language'] = strtoupper(Yii::app()->language);
        }
        parent::__construct($id, $module);
    }

}
