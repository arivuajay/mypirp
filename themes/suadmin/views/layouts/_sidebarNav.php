<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title"><i class="fa fa-car"></i> <span>MypirpClass</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="<?php echo $this->themeUrl . '/images/no-profile-pic.png'; ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo Inflector::camel2words(Yii::app()->user->name) ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->    
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Dashboard</h3>
                <?php
                // Current controller name
                $_controller = Yii::app()->controller->id;                  
                $_action = Yii::app()->controller->action->id;
                $this->widget('zii.widgets.CMenu', array(
                    'activateParents' => true,
                    'encodeLabel' => false,
                    'activateItems' => true,
                    'items' => array(
                        array('label' => '<i class="fa fa-home"></i> <span>Home</span>', 'url' => array('/suadmin/default'), 'active' => ($_controller == 'default' &&  $_action == "index")),
                        array('label' => '<i class="fa fa-users"></i> <span>Admin Users</span>', 'url' => array('/suadmin/admin'), 'active' => $_controller == 'admin'),                        
                        array('label' => '<i class="fa fa-desktop"></i> <span>Edit Profile</span>', 'url' => array('/suadmin/default/profile'), 'active' => ($_controller == 'default' &&  $_action == "profile")),
                        array('label' => '<i class="fa fa-sign-out"></i> <span>Logout</span>', 'url' => array('/suadmin/default/logout')),
                    ),
                    'htmlOptions' => array('class' => 'nav side-menu')
                ));
                ?>
            </div>          
        </div>
        <!-- /sidebar menu -->
    </div>
</div>