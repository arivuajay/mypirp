<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $this->themeUrl.'/images/no-profile-pic.png';?>" alt=""><?php echo Inflector::camel2words(Yii::app()->user->name) ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">   
                        <li><?php echo CHtml::link('Edit Profile', array('/suadmin/default/profile'), array("class" => "")) ?>  </li>
                        <li><?php echo CHtml::link('Change password', array('/suadmin/default/changepassword'), array("class" => "")) ?>  </li>
                        <li><?php echo CHtml::link('<i class="fa fa-sign-out pull-right"></i> Log Out</a>', array('/suadmin/default/logout'), array("class" => "")) ?></li>  
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>      
