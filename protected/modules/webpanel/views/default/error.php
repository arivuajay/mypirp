<?php
$this->title = $name;
if (isset(Yii::app()->user->admin_id) && Yii::app()->user->admin_id != "") {
   $homeurl = CHtml::link('home page', array('/webpanel'));
} else {
   $homeurl = CHtml::link('home page', array('/affiliate'));
}
?>
<!-- Main content -->
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"> <?php echo $error['code']; ?></h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
            <p>
                We could not find the page you were looking for.

            </p>
            <p>please go back to the <?php echo $homeurl; ?></p>

        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

</section><!-- /.content -->
