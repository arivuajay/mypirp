<header class="header">
    <?php echo CHtml::link(Yii::app()->name, array('/affiliate/'), array('class' => 'logo'));
    $aff_infos = DmvAffiliateInfo::getAffiliateInfo();
    ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><?php echo Inflector::camel2words(Yii::app()->user->name) ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <p><?php echo Inflector::camel2words(Yii::app()->user->name) ?></p>
                            <p><?php echo $aff_infos->agency_code;?>&nbsp;&nbsp;&nbsp;<?php echo $aff_infos->agency_name;?></p>
                        </li>
                         <!-- Menu Body-->               
                        <!-- Menu Footer-->
                        <li class="user-footer">                           
                            <div class="pull-right">
                                <?php echo CHtml::link('Sign out', array('/affiliate/default/logout'), array('class' => 'btn btn-default btn-flat')) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<?php
$headermenus = <<< EOD
    
        jQuery('.dropdown-toggle').dropdown();    
EOD;
Yii::app()->clientScript->registerScript('_form55', $headermenus);
?>