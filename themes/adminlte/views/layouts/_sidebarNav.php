<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left info">
                <p>Hello, <?php echo Inflector::camel2words(Yii::app()->user->name) ?></p>
                <a href="javascript:void(0)">
                    <i class="fa fa-circle text-success"></i> Online
                </a>
            </div>
        </div>

        <?php
        // Current controller name
        $_controller = Yii::app()->controller->id;
        $_action = Yii::app()->controller->action->id;
        $this->widget('zii.widgets.CMenu', array(
            'activateParents' => true,
            'encodeLabel' => false,
            'activateItems' => true,
            'items' => array(
                array('label' => '<i class="fa fa-users"></i> <span>Affliates</span>', 'url' => array('/webpanel/affiliates')),
                array('label' => '<i class="fa fa-users"></i> <span>Instructors</span>', 'url' => array('/webpanel/instructors')),
                array('label' => '<i class="fa fa-envelope-o"></i> <span>Messages</span>', 'url' => array('/webpanel/messages')),
                array('label' => '<i class="fa fa-file"></i> <span>Documents</span>', 'url' => array('/webpanel/postdocument')),               
                array('label' => '<i class="fa fa fa-list"></i> <span>Schedules</span>', 'url' => array('/webpanel/schedules')),
                array('label' => '<i class="fa fa fa-users"></i> <span>Manage students</span>', 'url' => array('/webpanel/students/managestudents')),
                array('label' => '<i class="fa fa fa-search"></i> <span>Search students</span>', 'url' => array('/webpanel/students/index')),               
                array('label' => '<i class="fa fa fa-print"></i> <span>Print students</span>', 'url' => array('/webpanel/students/printstudents')),               
                array('label' => '<i class="fa fa fa-dollar"></i> <span>Payments</span>', 'url' => array('/webpanel/payments')),               
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
