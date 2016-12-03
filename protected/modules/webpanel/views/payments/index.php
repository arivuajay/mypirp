<?php
/* @var $this PaymentsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Payments';
$this->breadcrumbs = array(
    'Payments',
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
        if (AdminIdentity::checkAccess('webpanel.schedules.delete')) {
            echo CHtml::link('<i class="fa fa-trash"></i>&nbsp;&nbsp;Delete Class', array('/webpanel/payments/deleteclass'), array('class' => 'marginleft btn btn-danger pull-right'));
        }
        ?>
        <?php
        if (AdminIdentity::checkAccess('webpanel.payments.create')) {
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Payment For New Class', array('/webpanel/payments/create'), array('class' => 'btn btn-success pull-right'));
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
                'header' => 'Agency Code',
                'name' => 'dmvClasses.Affliate.agency_code',
                'value' => function($data) {
                    if ($data->dmvClasses->affiliate_id != "")
                        echo $data->dmvClasses->Affliate->agency_code;
                    else
                        echo "-";
                }
            ),
            array(
                'header' => 'Class Name',
                'name' => 'dmvClasses.clas_date',
                'value' => function($data) {
                    if ($data->dmvClasses->clas_date != "")
                        echo date("F d,Y", strtotime($data->dmvClasses->clas_date));
                    else
                        echo "-";
                }
            ),
            array(
                'name' => 'payment_date',
                'value' => function($data) {
                    if (true == strtotime($data->payment_date))
                        echo Myclass::date_dispformat($data->payment_date);
                    else
                        echo "-";
                }
            ),
            array(
                'header' => 'Payment Time',
                'name' => 'payment_date',
                'value' => function($data) {
                    if (true == strtotime($data->payment_date))
                        echo Myclass::time_dispformat($data->payment_date) . ' EST';
                    else
                        echo "-";
                }
            ),
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
            'cheque_number',
            /*
              'payment_complete',
              'payment_notes',
              'print_certificate',
              'moneyorder_number',
              'total_students',
             */
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.payments.update')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.payments.delete')"),
                )
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            // 'filter' => $model,
            'type' => 'striped bordered datatable',
            'enableSorting' => false,
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Payments</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>
<?php
$js = <<< EOD
$(document).ready(function(){

$('.year').datepicker({ dateFormat: 'yyyy' });
$('.date').datepicker({ format: 'yyyy-mm-dd' });

});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>