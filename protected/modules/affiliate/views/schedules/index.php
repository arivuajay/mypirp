<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Manage Classes';
$this->breadcrumbs = array(
    'Manage Classes',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">&nbsp;</div>
<p><strong>Note: ASI staff will enter your class schedules. Once you see your class appear here then you can enter your students into that class. </strong></p>
<?php //$this->renderPartial('_search', compact('model')); ?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array(
                'header' => 'Date',
                'name' => 'clas_date',
                'value' => function($data) {
                    echo date('m/d/Y', strtotime($data->clas_date));
                },
            ),
            'start_time',
            'end_time',
            'loc_city',
            'loc_state',
            'zip',
            array(
                'header' => 'Instructor',
                'name' => 'Instructor.ins_first_name',
                'value' => function($data) {
                 echo   $data->Instructor->ins_first_name." ".$data->Instructor->instructor_last_name;
                }       
            ),
            array(
                'header' => 'Submit Class',
                'value' => function($data) {
                    if ($data->show_admin == "N") {
                        
                    } else {
                        echo $this->checkprintcertificate($data->clas_id);
                    }
                },
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{add_students}',
                'buttons' => array(
                    'add_students' => array(
                        'label' => "<i class='fa fa-list-ol'></i>",
                        'url' => 'Yii::app()->createAbsoluteUrl("/affiliate/students/addbulkstudents/cid/".$data->clas_id)',
                        'options' => array('class' => 'newWindow', 'title' => 'Add Bulk Students'),
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
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Classes</h3></div><div class="panel-body">{items}{pager}</div></div>',
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