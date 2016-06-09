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
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?php echo $total_websites;?>
                        </h3>
                        <p>
                            Websites
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion-earth"></i>
                    </div>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/webpanel/websites') ?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $total_courses;?>
                        </h3>
                        <p>
                           Courses
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion-filing"></i>
                    </div>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('/webpanel/courses') ?>" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->


    </section><!-- /.content -->

