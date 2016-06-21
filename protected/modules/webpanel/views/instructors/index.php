<?php
/* @var $this InstructorsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Instructors Management';
$this->breadcrumbs = array(
    'Instructors',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerScriptFile($themeUrl . '/js/datatables/jquery.dataTables.js', $cs_pos_end);
$cs->registerScriptFile($themeUrl . '/js/datatables/dataTables.bootstrap.js', $cs_pos_end);
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        if (AdminIdentity::checkAccess('webpanel.instructors.create')) {
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create an Instructor', array('/webpanel/instructors/create'), array('class' => 'btn btn-success pull-right'));
        }
        ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search', compact('model', 'affiliates', 'instructors')); ?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'instructor_code',
            'instructor_last_name',
            'ins_first_name',
            array(
                'header' => 'status',
                'name' => 'enabled',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'sortable' => false,
                'filter' => CHtml::activeDropDownList($model, 'enabled', array("Y" => "Enabled", "N" => "Disabled"), array('class' => 'form-control', 'prompt' => 'All')),
                'value' => function($data) {
            echo ($data->enabled == "Y") ? "<i class='fa fa-circle text-green'></i>" : "<i class='fa fa-circle text-red'></i>";
        }),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.instructors.edit')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.instructors.delete')")
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Instructors</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>

<?php
$ajaxInstructorsUrl = Yii::app()->createUrl('/webpanel/instructors/getinstructors');
?>
<script type="text/javascript">
    $(document).ready(function () {
        //$.fn.dataTableExt.sErrMode = 'throw';
        $("#DmvAddInstructor_Affiliate").change(function () {
            var id = $(this).val();
            var dataString = 'id=' + id;

            $.ajax({
                type: "POST",
                url: '<?php echo $ajaxInstructorsUrl; ?>',
                data: dataString,
                cache: false,
                success: function (html) {
                    $("#DmvAddInstructor_Instructor").html(html);
                }
            });
        });
    });
</script>