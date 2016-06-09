<?php

class SiteModule extends CWebModule {
    
    public $homeUrl = array('/site/default/index');
    public $layout = '//layouts/main';
    
    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'site.components.*',
        ));
        Yii::app()->theme = 'site'; 
        $this->layoutPath = Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.layouts');
        
        $curr_domain = Yii::app()->request->hostInfo;  
       
        if (!isset(Yii::app()->session['wid']) && !isset(Yii::app()->session['dname']) && Yii::app()->session['wid']=="" && Yii::app()->session['dname']!=$curr_domain)
        {  
            $criteria = new CDbCriteria();
            $criteria->addCondition("domainname=:dname");
            $criteria->addCondition("status=1");
            $criteria->params = array(':dname' => $curr_domain);
            $domaininfos = Websites::model()->findAll($criteria);
            if(!empty($domaininfos))
            {
                $wid = "";
                foreach($domaininfos as $infos)
                {
                    $wid = $infos->wid;
                    $domainname = $infos->domainname;                  
                } 
                Yii::app()->session['wid'] = $wid;
                Yii::app()->session['dname'] = Yii::app()->request->hostInfo;     
            } 
        }
      
        
        $this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => '/site/default/error'),
            'user' => array(
                'class' => 'CWebUser',
                'allowAutoLogin' => true,
            )
        ));

        Yii::app()->user->setStateKeyPrefix('_site');
        Yii::app()->user->loginUrl = Yii::app()->createUrl("/{$this->id}/default/index");
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
