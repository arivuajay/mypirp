<?php
/* @var $this PaymentsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Print Certificates';
$this->breadcrumbs = array(
    'Print Certificates',
);
?>
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
                        echo date("F d,Y", strtotime($data->dmvClasses->clas_date))."  ".$data->dmvClasses->start_time." To ".$data->dmvClasses->end_time;
                    else
                        echo "-";
                }
            ),
            array(
                'header' => 'Print Certificates',
                'name' => 'print_certificate',
                'value' => function($data) {
                    echo "<a href='".Yii::app()->createAbsoluteUrl("webpanel/printcertificate/printstudentcertificate/id/".$data->class_id)."'>Print certificates</a>";
                 }
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array(
                        'url' => 'Yii::app()->createAbsoluteUrl("webpanel/printcertificate/update/id/".$data->class_id)',
                        'visible' => "AdminIdentity::checkAccess('webpanel.printcertificate.update')"
                    ),
                    'delete' => array(
                        'url' => 'Yii::app()->createAbsoluteUrl("webpanel/printcertificate/delete/id/".$data->class_id)',
                        'visible' => "AdminIdentity::checkAccess('webpanel.printcertificate.delete')"
                    ),
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            // 'filter' => $model,
            'type' => 'striped bordered datatable',
            'enableSorting' => false,
            'dataProvider' => $model->print_certificate_search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Print Certificates</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>