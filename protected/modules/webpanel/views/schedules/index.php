<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Manage Schedules';
$this->breadcrumbs = array(
    'Manage Schedules',
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
            echo '&nbsp;&nbsp;';
            echo CHtml::link('<i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Delete Selected', '', array('class' => 'marginleft btn btn-danger pull-right','id'=>'class-deleted'));
         }
        if (AdminIdentity::checkAccess('webpanel.schedules.create')) {
            echo CHtml::link('<i class="fa fa-upload"></i>&nbsp;&nbsp;Upload Schedule', array('/webpanel/schedules/uploadschedule'), array('class' => 'marginleft btn btn-info pull-right','id'=>'upload-schedule'));
            echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Schedule', array('/webpanel/schedules/create'), array('class' => 'btn btn-success pull-right','id'=>'add-schedule'));
            
        }
        ?>
        
    </div>
</div>
<?php $loading_image = Yii::app()->getBaseUrl(true) . '/themes/adminlte/img/ajax-loader.gif'; ?>
<div id="loading-image" style="text-align: center; display: none;"><img src='<?php echo $loading_image; ?>' width="64" height="64" /><br> Please Wait...</div>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search', compact('model')); ?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array(
                'class' => 'CCheckBoxColumn',
                'selectableRows' => 1,
                'value' => '$data["clas_id"]',
                'checkBoxHtmlOptions' => array("name" => "idList[]"),
            ),
            array(
                'header' => 'Agency code',
                'name' => 'Affliate.agency_code',
                'value' => $data->Affliate->agency_code,
            ),
            array(
                'name' => 'clas_date',
                'value' => function($data) {
                    echo Myclass::date_dispformat($data->clas_date);
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
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{add_students}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.schedules.update')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.schedules.delete')"),
                    'add_students' => array(
                        'label' => "<i class='fa fa-list-ol'></i>",
                        'url' => 'Yii::app()->createAbsoluteUrl("/webpanel/students/addbulkstudents/aid/".$data->affiliate_id."/cid/".$data->clas_id)',
                        'options' => array('class' => 'newWindow', 'title' => 'Add Bulk Students'),
                        'visible' => '(AdminIdentity::checkAccess("webpanel.students.addbulkstudents") && ($data->Affliate->enabled=="Y"))'
                    ),
                ),
            )
        );
        $this->widget('booster.widgets.TbExtendedGridView', array(
            //'filter' => $model,
            'type' => 'bordered datatable',
            'enableSorting' => false,
            'dataProvider' => $model->search(),
            'rowCssClassExpression'=>'($data->Affliate->enabled=="Y")?"aff_active":"aff_disbaled"',
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Schedules</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>

<?php
$validate_url = Yii::app()->createUrl('/webpanel/schedules/deleteselectedall');
$success_url = Yii::app()->createUrl('/webpanel/schedules/index/success/');
$js = <<< EOD
$(document).ready(function(){
    
    $('#class-deleted').on('click', function(){
        var idList    = $("input[type=checkbox]:checked").serialize();

        if(idList)
        {
            $('#loading-image').show();
        
            $('#class-deleted').hide();
            $('#add-schedule').hide();
            $.ajax({
                method: "POST",
                url: "{$validate_url}",
                async: false,
                data: idList,
                success: function(res){
                        var red_url="{$success_url}"+'/'+res;
                    window.location= red_url;
                        return false;
                    },

              });
              return false;
        }else{
            alert('Please select any one checkbox.');
        }
    });
 
    $("#export_csv").click(function () {
        var startdate = $("#DmvClasses_startdate").val();
        var enddate = $("#DmvClasses_enddate").val();

        $("#startdate_error").hide();
        $("#enddate_error").hide();

        if (startdate == "")
        {
            $("#startdate_error").show();
            return false;
        }

        if (enddate == "")
        {
            $("#enddate_error").show();
            return false;
        }

        return true;

    });

});
EOD;
Yii::app()->clientScript->registerScript('_form_schedule', $js);
?>