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
        $cs->registerCssFile($themeUrl . '/build/css/custom-full.css');        
        $cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
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
                <footer>
                    <div class="pull-right">Mypirpclass - Super Admin Management </div>
                    <div class="clearfix"></div>
                </footer>
            </div>
        </div>   
        <?php
        $cs_pos_end = CClientScript::POS_END;
        $cs->registerScriptFile($themeUrl . '/build/js/custom.js', $cs_pos_end);
        $cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
        $js = <<< EOD
                
        jQuery('.year').datepicker({dateFormat: 'yyyy', forceParse: false});
        jQuery('.date').datepicker({format: 'mm/dd/yyyy', forceParse: false});   
EOD;
        $cs->registerScript('_additional_s', $js);
        ?>
    </body>
    
    
</html>