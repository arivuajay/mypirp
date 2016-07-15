<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Manage Students';
$this->breadcrumbs = array(
    'Manage Students',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
?>
<?php if ($model->affiliateid != "" || $model->agencycode != "" || $model->agencyname != "" || $model->start_date != "" || $model->end_date != "") { ?>
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <?php
            if (AdminIdentity::checkAccess('webpanel.students.create')) {
                echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Student', array('/webpanel/students/create'), array('class' => 'btn btn-success pull-right'));
            }
            ?>

        </div>
    </div>
<?php } ?>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search_students', compact('model', 'affiliates')); ?>

<?php if ($model->affiliateid != "" || $model->agencycode != "" || $model->agencyname != "" || $model->start_date != "" || $model->end_date != "") { ?>
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <?php
            $gridColumns = array(
                array(
                    'header' => 'Agency code',
                    'name' => 'Affliate.agency_code',
                    'value' => $data->Affliate->agency_code,
                ),
                array(
                    'header' => 'Agency Name',
                    'name' => 'Affliate.agency_name',
                    'value' => $data->Affliate->agency_name,
                ),
                array(
                    'header' => 'Schedule Date and time',
                    'name' => 'clas_date',
                    'value' => function($data) {
                        echo date("F d,Y", strtotime($data->clas_date)) . " " . $data->start_time . " to " . $data->end_time;
                    },
                ),
                array(
                    'header' => 'Action',
                    'name' => 'studentsCount',
                    'filter' => false,
                    'value' => function($data) {
                        echo ( $data->studentsCount > 0) ? "<a href='" . Yii::app()->createAbsoluteUrl("/webpanel/students/viewstudents/aid/" . $data->affiliate_id . "/cid/" . $data->clas_id) . "'>View/Edit students</a>" : "There are no records in this class";
                    }
                ),
            );
            $this->widget('booster.widgets.TbExtendedGridView', array(
                //'filter' => $model,
                'type' => 'striped bordered datatable',
                'enableSorting' => false,
                'dataProvider' => $model->search(),
                'responsiveTable' => true,
                'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Schedules</h3></div><div class="panel-body">{items}{pager}</div></div>',
                'columns' => $gridColumns
                    )
            );
            ?>
        </div>
    </div>
    <?php
}
?>