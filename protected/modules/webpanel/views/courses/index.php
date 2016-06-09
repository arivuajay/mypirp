<?php
/* @var $this CoursesController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Courses';
$this->breadcrumbs=array(
	'Courses',
);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create Course', array('/webpanel/courses/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'ctitle_en',				
            array(
                'header' => 'Status (EN)',
                'name' => 'status',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'sortable' => false,
                'value' => function($data) {
                    echo ($data->status == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
                  },
               'filter' => CHtml::activeDropDownList($model, 'status', array("1" => "Enabled", "0" => "Disabled"), array('class' => 'form-control', 'prompt' => 'All')),
            ),
            array(
                'header' => 'Status (ES)',
                'name' => 'status_es',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'sortable' => false,
                'value' => function($data) {
                    echo ($data->status_es == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
                  },
               'filter' => CHtml::activeDropDownList($model, 'status_es', array("1" => "Enabled", "0" => "Disabled"), array('class' => 'form-control', 'prompt' => 'All')),
            ),
            array(
                'name' => 'created_at',
                'filter' => FALSE
            ),		
            array(
            'header' => 'Actions',
            'class' => 'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
            'template' => '{update}&nbsp;&nbsp;{delete}',
            )
        );

       // $total=$model->search()->getTotalItemCount();

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,       
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Courses</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>