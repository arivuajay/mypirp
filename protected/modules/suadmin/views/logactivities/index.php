<?php
/* @var $this AdminController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Log Activities';
$this->breadcrumbs = array(
    'Log Activities',
);

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>

<?php $this->renderPartial('_search', compact('model','adminvals')); ?>
<div class="col-md-6 col-sm-6 col-lg-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo $this->title; ?></h2>            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php
            $gridColumns = array(
                array(
                    'header' => 'Client Name',
                    'name' => 'Admin.username',
                    'value' => $data->Admin->username,
                ),
                'aud_message',
                'aud_ip_address',
                'aud_created_date',
                array(
                    'header' => 'Actions',
                    'class' => 'booster.widgets.TbButtonColumn',
                    'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                    'template' => '{delete}',
                )
            );

            $this->widget('booster.widgets.TbExtendedGridView', array(
                //'htmlOptions' => array('class' => 'example'),
                'enableSorting' => false,
                // 'filter' => $model,
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
<?php
$js = <<< EOD
$(document).ready(function(){

    $('.year').datepicker({ dateFormat: 'yyyy' });
    $('.date').datepicker({ format: 'yyyy-mm-dd' });

});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>