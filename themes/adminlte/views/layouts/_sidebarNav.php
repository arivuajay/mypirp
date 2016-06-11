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
                array('label' => '<i class="fa fa-users"></i> <span>Affliates</span>', 'url' => array('/webpanel/affiliates'), 'active' => $_controller == 'affiliatesController'),
                array('label' => '<i class="fa fa-users"></i> <span>Instructors</span>', 'url' => array('/webpanel/instructors'), 'active' => $_controller == 'instructorsController'),
                array('label' => '<i class="fa fa-newspaper-o"></i> <span>Messages</span>', 'url' => array('/webpanel/messages'), 'active' => $_controller == 'messagesController'),               
                array('label' => '<i class="fa fa fa-list"></i> <span>Schedules</span>', 'url' => array('/webpanel/schedules'), 'active' => $_controller == 'schedulesController'),               
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
