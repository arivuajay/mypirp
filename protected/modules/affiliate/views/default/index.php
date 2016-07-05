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
        <?php if($total_schedules>0){ ?>
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
                    <i class="ion-calendar"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/affiliate/schedules') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->   
        <?php }?>
        <?php if($total_students>0){ ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-olive">
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
        <?php }?>
        <?php if($total_documents>0){ ?>
         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>
                        <?php echo $total_documents; ?>
                    </h3>
                    <p>
                        Documents
                    </p>
                </div>
                <div class="icon">
                    <i class="ion-document"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/affiliate/postdocument') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <?php }?>
        <?php if($total_messages>0){ ?>
         <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php echo $total_messages; ?>
                    </h3>
                    <p>
                        Messages
                    </p>
                </div>
                <div class="icon">
                    <i class="ion-document"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/affiliate/messages') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <?php }?>
    </div><!-- /.row -->


</section><!-- /.content -->

