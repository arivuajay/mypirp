<!DOCTYPE html>
<html lang="en-US" class="bg-black">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo CHtml::encode($this->title); ?></title>
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($themeUrl . '/lib/bs3/css/bootstrap.css');
        $cs->registerCssFile($themeUrl . '/css/font-awesome/css/font-awesome.css');
        $cs->registerCssFile($themeUrl . '/css/AdminLTE.css');
        $cs->registerCssFile('http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css');
        $cs->registerCssFile($themeUrl . '/css/bootstrap-theme.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        ?>
    </head>
    <body class="bg-black">
        <?php echo $content ?>
        <?php
        $cs_pos_end = CClientScript::POS_END;

        $cs->registerCoreScript('jquery');

        $cs->registerScriptFile($themeUrl . '/lib/bs3/js/bootstrap.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/app.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/iCheck/iCheck.js', $cs_pos_end);
        ?>
    </body>
</html>