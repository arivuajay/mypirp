<?php
$this->title = $name;
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
            <p>please go back to the <a href='<?php echo Yii::app()->createAbsoluteUrl('/') ?>'>home page</a>.</p>

        </div><!-- /.error-content -->
    </div><!-- /.error-page -->

</section><!-- /.content -->
