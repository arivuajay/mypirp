<?php
$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);
?>
<!-- Right side column. Contains the navbar and content of the page -->
<!-- Main content -->
<section class="content">

    <!-- Small boxes (Stat box) -->
    <div class="row">
         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo $total_schedules; ?>
                    </h3>
                    <p>
                        Schedules
                    </p>
                </div>
                <div class="icon">
                    <i class="ion-email"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/affiliate/schedules') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->   
        
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo $total_students; ?>
                    </h3>
                    <p>
                        Students
                    </p>
                </div>
                <div class="icon">
                    <i class="ion-person-stalker"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/affiliate/students') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        
    </div><!-- /.row -->


</section><!-- /.content -->

