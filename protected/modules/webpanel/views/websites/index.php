<?php
/* @var $this WebsitesController */
/* @var $dataProvider CActiveDataProvider */

$this->title='Websites';
$this->breadcrumbs=array(
	'Websites',
);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create Website', array('/webpanel/websites/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'domainname',
            'phone',            	
            array(
                'header' => 'Status',
                'name' => 'status',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'sortable' => false,
                'value' => function($data) {
                    echo ($data->status == 1) ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
                  },
               'filter' => CHtml::activeDropDownList($model, 'status', array("1" => "Active", "0" => "Deactive"), array('class' => 'form-control', 'prompt' => 'All')),
            ),
            array(
                'name' => 'created_at',
                'filter' => FALSE
            ),
            array(
            'header' => 'Actions',
            'class' => 'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
            'template' => '{view}&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;{delete}',
            'buttons' => array(
                    'view' => array(
                        'url' => '$data->domainname', 
                        'options' => array('target' => '_blank',"title"=>"View Website"),
                    )
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Websites</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
            )
        );
        ?>
    </div>
</div>