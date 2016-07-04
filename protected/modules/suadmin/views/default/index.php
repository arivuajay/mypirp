<?php
$this->title = 'Dashboard';
$this->breadcrumbs = array(
    $this->title
);
?>
 
    <!-- top tiles -->
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count"><?php echo $total_admins;?></div>
                <h3>Total Clients </h3>               
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-link"></i></div>
                <div class="count"><?php echo $total_affs;?></div>
                <h3>Total Affliates</h3>               
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-group"></i></div>
                <div class="count"><?php echo $total_ins;?></div>
                <h3>Total Instructors</h3>              
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-calendar"></i></div>
                <div class="count"><?php echo $total_schedules;?></div>
                <h3>Total Shedules</h3>               
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                <div class="count"><?php echo $total_students;?></div>
                <h3>Total Students</h3>               
            </div>
        </div>
    </div>
    <!-- /top tiles -->        

