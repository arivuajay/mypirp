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
        <?php if (AdminIdentity::checkAccess('webpanel.affliates.index')) {?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo $total_affiliates; ?>
                    </h3>
                    <p>
                        Affiliates
                    </p>
                </div>
                <div class="icon">
                    <i class="ion-person-stalker"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/webpanel/affiliates') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <?php }?>
        <?php if (AdminIdentity::checkAccess('webpanel.instructors.index')) {?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo $total_instructors; ?>
                    </h3>
                    <p>
                        Instructors
                    </p>
                </div>
                <div class="icon">
                    <i class="ion-person-stalker"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/webpanel/instructors') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <?php }?>
        <?php if (AdminIdentity::checkAccess('webpanel.schedules.index')) {?>
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
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/webpanel/schedules') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <?php }?>
        <?php if (AdminIdentity::checkAccess('webpanel.messages.index')) {?>
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
                    <i class="ion-email"></i>
                </div>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/webpanel/messages') ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <?php }?>
    </div><!-- /.row -->


</section><!-- /.content -->

