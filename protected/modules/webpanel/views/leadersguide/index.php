<?php
/* @var $this LeadersguideController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Leaders Guide';
$this->breadcrumbs = array(
    'Leaders Guide',
);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        if (AdminIdentity::checkAccess('webpanel.leadersguide.create')) {
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Leaders Guide', array('/webpanel/leadersguide/create'), array('class' => 'btn btn-success pull-right'));
        }
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array(
                'name' => 'payment_date',
                'value' => function($data) {
                    if (true == strtotime($data->payment_date))
                        echo Myclass::date_dispformat($data->payment_date);
                    else
                        echo "-";
                }
            ),
            'number_of_guides',
            'guide_fee',
            'shipping_fee',
            'payment_amount',
            array(
                'name' => 'payment_type',
                'value' => function($data) {
                    if ($data->payment_type != "") {
                        $card_types = Myclass::card_types();
                        if (array_key_exists($data->payment_type, $card_types)) {
                            echo $card_types[$data->payment_type];
                        } else {
                            echo "-";
                        }
                    }
                }
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.leadersguide.update')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.leadersguide.delete')"),
                )
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            //'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Leaders Guides</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>