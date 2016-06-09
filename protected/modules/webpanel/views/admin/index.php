<?php
/* @var $this AdminController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Administration';
$this->breadcrumbs=array(
	'Admin users',
);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create User', array('/webpanel/admin/create'), array('class' => 'btn btn-success pull-right')); ?>        
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
		'username',				
		'email',                 
                array(
                    'header' => 'status',
                    'name' => 'status',
                    'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                    'type' => 'raw',
                    'sortable' => false,
                    'filter' => CHtml::activeDropDownList($model, 'status', array("1" => "Enabled", "0" => "Disabled"), array('class' => 'form-control', 'prompt' => 'All')),
                    'value' => function($data) {
                        echo ($data->status == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
                }),
                array(
                    'header' => 'Modified at',
                    'name' => 'modified_at',
                    'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                    'type' => 'raw',
                    'sortable' => false,
                    'filter' => false,
                    'value' => $data->modified_at
                ),		
                array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',            
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '&nbsp;{update}&nbsp;&nbsp;{delete}',
                'buttons' => array(                           
                        'delete' => array(
                          'visible' => function($row, $data) {
                                        return ($data->id==1)?false:true;
                                    }
                        ),
                    ),
                )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Admin users</h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>