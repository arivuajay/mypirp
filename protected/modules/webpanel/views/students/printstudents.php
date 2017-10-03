<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Print Students';
$this->breadcrumbs = array(
    'Print Students',
);
?>
<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'instructors-search-form',
                        'method' => 'get',
                        'action' => array('/webpanel/students/printstudents/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'startdate', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'startdate', array('class' => 'form-control date')); ?>                               
                            </div> 
                            (MM/DD/YYYY)
                            <div style="display: none;" id="startdate_error" class="errorMessage">Please select start date.</div>
                        </div>
                    </div> 

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'enddate', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'enddate', array('class' => 'form-control date')); ?>                               
                            </div> 
                            (MM/DD/YYYY)
                            <div style="display: none;" id="enddate_error" class="errorMessage">Please select end date.</div>
                        </div>
                    </div> 

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'affiliateid', array('class' => ' control-label')); ?> 
                            <?php echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control')); ?>            
                        </div>
                    </div> 

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'instructorid', array('class' => ' control-label')); ?> 
                            <?php echo $form->dropDownList($model, 'instructorid', $instructors, array('class' => 'form-control')); ?>     
                        </div>
                    </div> 

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filter', array("id" => 'print_res', 'class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>                  
                    <?php $this->endWidget(); ?>
                </div>
            </section>

        </div>
    </div>
</div>

<?php
if ($model->startdate != "" && $model->enddate != "") {

    $totalstudents= "Total Students = ".$model->search()->getTotalItemCount();
    $aff_info = ($model->affiliate_id > 0) ? "<strong>" . $model->dmvAffiliateInfo->agency_name . " " . $model->dmvAffiliateInfo->agency_code . "</strong>" : "";
    $date_disp = "From " .Myclass::date_dispformat($model->startdate) . " until " . Myclass::date_dispformat($model->enddate);
    ?>
    <a href="javascript:void(0);" id="printdiv" class="btn m-b-xs  btn-primary pull-right"> <i class="fa fa-print"></i>  Print</a>

    <div class="col-lg-12 col-md-12">&nbsp;</div>

    <div id="Getprintval">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <?php
                $gridColumns = array(
                    array(
                        'header' => 'Certificate Number',
                        'name' => 'certificatenumber',
                        'value' => function($data) {
                            echo $this->getcertificatenumber($data->student_id, $data->clas_id);
                        },
                    ),
                    'last_name',
                    'middle_name',
                    'first_name',
                    'licence_number',
                    array(
                        'header' => 'DOB',
                        'name' => 'dob',
                        'value' => function($data) {
                            echo ($data->dob != "") ? Myclass::date_dispformat($data->dob) : "-";
                        }
                    ),
                    array(
                        'header' => 'Gender',
                        'name' => 'gender',
                        'value' => function($data) {
                            if ($data->gender ==
                                    "M")
                                echo "Male";
                            elseif ($data->
                                    gender == "F")
                                echo "Female";
                            else
                                echo "-";
                        }
                    ),
                );

                $this->widget('booster.widgets.TbExtendedGridView', array(
                    //  'filter' => $model,
                    'type' => 'striped bordered datatable',
                    'enableSorting' => false,
                    'dataProvider' => $model->search(),
                    'responsiveTable' => true,
                    'template' => '<div class="panel panel-primary">'
                    . '<div class="panel-heading">'
                    . '<div class="pull-right">{summary}</div>'
                    . '<h3 class="panel-title"> Students by Agency  '.$aff_info.'</h3>'
                    . '</div>'
                    . '<div class="panel-body">'
                    . '<p><h4>' . $date_disp . ' </h4></p>'
                    . '<p><h4>'. $totalstudents .'</h4></p>'
                    . '{items}{pager}</div>'
                    . '</div>',
                    'columns' => $gridColumns
                        )
                );
                ?>
            </div>
        </div>
    </div>
<?php }
?>
<?php
$ajaxInstructorsUrl = Yii::app()->createUrl('/webpanel/instructors/getinstructors');

$js = <<< EOD
$(document).ready(function(){
 
$("#printdiv").click(function() {   
    var innerContents = document.getElementById("Getprintval").innerHTML;
    var popupWinindow = window.open('', '_blank', 'width=600,height=700,scrollbars=yes,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
    popupWinindow.document.open();
    popupWinindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="/themes/adminlte/css/print.css" /></head><body onload="window.print()">' + innerContents + '</html>');    popupWinindow.document.close();  
});     
        
  $("#Students_affiliate_id").change(function () {
        var id = $(this).val();
        var dataString = 'id=' + id;

        $.ajax({
            type: "POST",
            url: '{$ajaxInstructorsUrl}',
            data: dataString,
            cache: false,
            success: function (html) {
                $("#Students_instructorid").html(html);
            }
        });
    });
       

$("#print_res").click(function() {
    var startdate = $("#Students_startdate").val();
    var enddate = $("#Students_enddate").val();
        
    $("#startdate_error").hide();    
    $("#enddate_error").hide();
   
   if(startdate=="")
    {
        $("#startdate_error").show();
        return false;
    }
    
   if(enddate=="")
    {
        $("#enddate_error").show();
        return false;
    }
        
    return true;
        
});   
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>