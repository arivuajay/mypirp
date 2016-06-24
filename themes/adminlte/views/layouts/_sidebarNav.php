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
                array('label' => '<i class="fa fa-users"></i> <span>Affliates</span>', 'url' => array('/webpanel/affiliates'), 'visible' => AdminIdentity::checkAccess('webpanel.affliates.index')),
                array('label' => '<i class="fa fa-users"></i> <span>Instructors</span>', 'url' => array('/webpanel/instructors'), 'visible' => AdminIdentity::checkAccess('webpanel.instructors.index')),
                array('label' => '<i class="fa fa-envelope-o"></i> <span>Messages</span>', 'url' => array('/webpanel/messages'), 'visible' => AdminIdentity::checkAccess('webpanel.messages.index')),
                array('label' => '<i class="fa fa-file"></i> <span>Documents</span>', 'url' => array('/webpanel/postdocument'), 'visible' => AdminIdentity::checkAccess('webpanel.postdocument.index')),
                array('label' => '<i class="fa fa fa-list"></i> <span>Schedules</span>', 'url' => array('/webpanel/schedules'), 'visible' => AdminIdentity::checkAccess('webpanel.schedules.index')),
                array('label' => '<i class="fa fa fa-users"></i> <span>Manage students</span>', 'url' => array('/webpanel/students/managestudents'), 'visible' => AdminIdentity::checkAccess('webpanel.students.managestudents')),
                array('label' => '<i class="fa fa fa-search"></i> <span>Search students</span>', 'url' => array('/webpanel/students/index'), 'visible' => AdminIdentity::checkAccess('webpanel.students.index')),
                array('label' => '<i class="fa fa fa-print"></i> <span>Print students</span>', 'url' => array('/webpanel/students/printstudents'), 'visible' => AdminIdentity::checkAccess('webpanel.students.printstudents')),
                array('label' => '<i class="fa fa fa-dollar"></i> <span>Payments</span>', 'url' => array('/webpanel/payments'), 'visible' => AdminIdentity::checkAccess('webpanel.payments.index')),
                array('label' => '<i class="fa fa fa-list"></i> <span>Book Orders</span>', 'url' => array('/webpanel/bookorders'), 'visible' => AdminIdentity::checkAccess('webpanel.bookorders.index')),
                array('label' => '<i class="fa fa fa-list"></i> <span>Leaders Guide</span>', 'url' => array('/webpanel/leadersguide'), 'visible' => AdminIdentity::checkAccess('webpanel.leadersguide.index')),
                array('label' => '<i class="fa fa fa-print"></i> <span>Print Certificates</span>', 'url' => array('/webpanel/printcertificate'), 'visible' => AdminIdentity::checkAccess('webpanel.printcertificate.index')),
                array('label' => '<i class="fa fa fa-print"></i> <span>Print Pending Certificates</span>', 'url' => array('/webpanel/printcertificate/pendingcertificates'), 'visible' => AdminIdentity::checkAccess('webpanel.printcertificate.pendingcertificates')),
                array('label' => '<i class="fa fa-bar-chart-o"></i> <span>Reports</span><i class="fa pull-right fa-angle-left"></i>', 'url' => '#',
                    'itemOptions' => array('class' => 'treeview'),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Book Order Reports</span>', 'url' => array('/webpanel/reports/bookorderreport'),'visible' => AdminIdentity::checkAccess('webpanel.reports.bookorderreport')),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Payment Reports</span>', 'url' => array('/webpanel/reports/paymentreport'), 'visible' => AdminIdentity::checkAccess('webpanel.reports.paymentreport')),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Quarterly/Annual Report</span>', 'url' => array('/webpanel/reports/quarterlyannualreport'), 'visible' => AdminIdentity::checkAccess('webpanel.reports.quarterlyannualreport')),
                        array('label' => '<i class="fa fa-angle-double-right"></i> <span>Monthly Report</span>', 'url' => array('/webpanel/reports/monthlyreport'), 'visible' => AdminIdentity::checkAccess('webpanel.reports.monthlyreport')),
                    ),
                    'visible' => AdminIdentity::checkAccess('webpanel.reports.index')
                ),
            ),
            'htmlOptions' => array('class' => 'sidebar-menu')
        ));
        ?>
    </section>
</aside>
