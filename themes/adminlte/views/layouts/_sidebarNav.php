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
                array('label' => '<i class="fa fa-user"></i> <span>Affliates</span>', 'url' => array('/webpanel/admin'), 'active' => $_controller == 'adminController' , 'visible' => (Yii::app()->user->id==1)?"1":"0"),
                array('label' => '<i class="fa fa-newspaper-o"></i> <span>Instructures</span>', 'url' => array('/webpanel/websites'), 'active' => $_controller == 'websiteController'),
                array('label' => '<i class="fa fa-calendar"></i> <span>Shedules</span>', 'url' => array('/webpanel/courses'), 'active' => $_controller == 'coursesController'),
                array('label' => '<i class="fa fa-calendar"></i> <span>Payments</span>', 'url' => array('/webpanel/courses'), 'active' => $_controller == 'coursesController'),
                array('label' => '<i class="fa fa-user"></i> <span>Manage Students</span>', 'url' => array('/webpanel/courses'), 'active' => $_controller == 'coursesController'),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
