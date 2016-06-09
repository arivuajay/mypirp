<!DOCTYPE html>
<html lang="en-US" class="">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo CHtml::encode($this->title); ?></title>
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();

  //     $cs->registerCssFile($themeUrl . '/lib/bs3/css/bootstrap.css');
        $cs->registerCssFile($themeUrl . '/css/font-awesome/css/font-awesome.css');         
        $cs->registerCssFile($themeUrl . '/css/bootstrap-theme.css');
        $cs->registerCssFile($themeUrl . '/css/AdminLTE.css');
        $cs->registerCssFile('http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css');      
        $cs->registerCssFile($themeUrl . '/css/custom.css');        
        $cs->registerScript('initial','var basepath = "'.Yii::app()->baseUrl.'";');
        ?>
    </head>
    <body class="skin-blue">
        <?php $this->renderPartial('//layouts/_headerBar'); ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php $this->renderPartial('//layouts/_sidebarNav'); ?>

            <?php echo $content; ?>
        </div>
        <?php
        $cs_pos_end = CClientScript::POS_END;

        $cs->registerCoreScript('jquery');

  //      $cs->registerScriptFile($themeUrl . '/lib/bs3/js/bootstrap.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/dropdown.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/iCheck/icheck.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/app.js', $cs_pos_end);
        ?>
    </body>
</html>