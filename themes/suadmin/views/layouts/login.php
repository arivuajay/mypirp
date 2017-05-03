<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MypirpClass | Login </title>
        <?php
        $themeUrl = $this->themeUrl;
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($themeUrl . '/vendors/bootstrap/dist/css/bootstrap.min.css');
        $cs->registerCssFile($themeUrl . '/vendors/font-awesome/css/font-awesome.min.css');
       // $cs->registerCssFile('https://colorlib.com/polygon/gentelella/css/animate.min.css');
        $cs->registerCssFile($themeUrl . '/build/css/custom.min.css');
        $cs->registerCssFile($themeUrl . '/css/custom.css');
        ?>
    </head>
    <body class="login">
        <?php echo $content ?>
        <?php
        $cs_pos_end = CClientScript::POS_END;

        $cs->registerCoreScript('jquery');
//
//        $cs->registerScriptFile($themeUrl . '/lib/bs3/js/bootstrap.js', $cs_pos_end);
//        $cs->registerScriptFile($themeUrl . '/js/app.js', $cs_pos_end);
//        $cs->registerScriptFile($themeUrl . '/js/iCheck/iCheck.js', $cs_pos_end);
        ?>
    </body>
</html>
