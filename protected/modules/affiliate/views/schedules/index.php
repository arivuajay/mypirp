<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Manage Schedules';
$this->breadcrumbs=array(
	'Manage Schedules',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create Schedule', array('/webpanel/schedules/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
        	'affiliate_id',
		'clas_date',		
		'start_time',
		'end_time',
		'loc_city',
		'loc_state',
		'zip',
                'instructor_id',
		/*
		'start_time2',
		'end_time2',
		'location',
		'loc_addr',		
		'country',		
		'show_admin',
		'pending',
		*/
        array(
        'header' => 'Actions',
        'class' => 'booster.widgets.TbButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{view}{update}{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Schedules</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>