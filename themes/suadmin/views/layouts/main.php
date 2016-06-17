<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo CHtml::encode($this->title); ?></title>
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($themeUrl . '/vendors/bootstrap/dist/css/bootstrap.min.css');
        $cs->registerCssFile($themeUrl . '/vendors/font-awesome/css/font-awesome.min.css');
        $cs->registerCssFile($themeUrl . '/build/css/custom.min.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        $cs->registerScript('initial', 'var basepath = "' . Yii::app()->baseUrl . '";');
        ?>      
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php $this->renderPartial('//layouts/_sidebarNav'); ?>  
                <?php $this->renderPartial('//layouts/_headerBar'); ?>       
                <?php echo $content; ?>
            </div>
        </div>   
        <?php
        $cs_pos_end = CClientScript::POS_END;
        $cs->registerScriptFile($themeUrl . '/build/js/custom.js', $cs_pos_end);
        ?>
    </body>
</html>