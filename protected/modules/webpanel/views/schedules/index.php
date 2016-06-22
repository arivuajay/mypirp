<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Manage Schedules';
$this->breadcrumbs = array(
    'Manage Schedules',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        if (AdminIdentity::checkAccess('webpanel.schedules.create')) {
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Schedule', array('/webpanel/schedules/create'), array('class' => 'btn btn-success pull-right'));
        }
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search', compact('model')); ?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array(
                'header' => 'Agency code',
                'name' => 'Affliate.agency_code',
                'value' => $data->Affliate->agency_code,
            ),
            'clas_date',
            'start_time',
            'end_time',
            'loc_city',
            'loc_state',
            'zip',
            array(
                'header' => 'Instructor',
                'name' => 'Instructor.ins_first_name',
                'value' => $data->Instructor->ins_first_name,
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{add_students}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.schedules.edit')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.schedules.delete')"),
                    'add_students' => array(
                        'label' => "<i class='fa fa-list-ol'></i>",
                        'url' => 'Yii::app()->createAbsoluteUrl("/webpanel/students/addbulkstudents/aid/".$data->affiliate_id."/cid/".$data->clas_id)',
                        'options' => array('class' => 'newWindow', 'title' => 'Add Bulk Students'),
                        'visible' => "AdminIdentity::checkAccess('webpanel.students.addbulkstudents')"
                    ),
                ),
            )
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
$js = <<< EOD
$(document).ready(function(){

    $("#DmvClasses_startdate").change(function () {
        if ($(this).val() != '') {
            $("#startdate_error").hide();
        }
    });
        
    $("#DmvClasses_enddate").change(function () {
        if ($(this).val() != '') {
            $("#enddate_error").hide();
        }
    });

    $("#export_csv").click(function () {
        var startdate = $("#DmvClasses_startdate").val();
        var enddate = $("#DmvClasses_enddate").val();

        $("#startdate_error").hide();
        $("#enddate_error").hide();

        if (startdate == "")
        {
            $("#startdate_error").show();
            return false;
        }

        if (enddate == "")
        {
            $("#enddate_error").show();
            return false;
        }

        return true;

    });

    $('.year').datepicker({ dateFormat: 'yyyy' });
    $('.date').datepicker({ format: 'yyyy-mm-dd' });

});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>