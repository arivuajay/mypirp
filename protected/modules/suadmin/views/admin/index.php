<?php
/* @var $this AdminController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Admin Management';
$this->breadcrumbs = array(
    'Admin users',
);
?>

<div class="col-md-6 col-sm-6 col-lg-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo $this->title; ?></h2>
            <div class="nav navbar-right">
                <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create User', array('/suadmin/admin/create'), array('class' => 'btn btn-success btn-sm pull-right')); ?>                  
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
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
                    'template' => '{view}&nbsp;{update}&nbsp;&nbsp;{delete}',
                    'buttons' => array
                        (
                        'view' => array
                            (
                            'url' => '$data->domain_url',
                            'options'=>array('target'=>'_blank')
                        ),                        
                    ),
                )
            );

            $this->widget('booster.widgets.TbExtendedGridView', array(
                //'htmlOptions' => array('class' => 'example'),
                'filter' => $model,
                'type' => 'striped bordered datatable',
                'dataProvider' => $model->search(),
                'responsiveTable' => true,
                'template' => '{items}{pager}',
                'columns' => $gridColumns
                    )
            );
            ?>
        </div>
    </div>
</div>