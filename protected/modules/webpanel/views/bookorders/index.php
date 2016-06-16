<?php
/* @var $this BookordersController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Book Orders';
$this->breadcrumbs = array(
    'Book Orders',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Book Order', array('/webpanel/bookorders/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(             
            //'instructor_id',
            //'client_type',
            // 'book_instructor',
            array(
                'name' => 'payment_date',
                'value' => function($data) {
                    if (true == strtotime($data->payment_date))
                        echo date("m/d/Y", strtotime($data->payment_date));
                    else
                        echo "-";
                }
            ),
            'number_of_books',
            'book_fee',
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
            // 'cheque_number',
            //'payment_complete',
            //'payment_notes',
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}',
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            //  'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Book Orders</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>