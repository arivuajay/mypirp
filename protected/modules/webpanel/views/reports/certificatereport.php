<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Certificate Report';
$this->breadcrumbs = array(
    'Certificate Report',
);
?>
<?php $this->renderPartial('_search_certificate', compact('model')); ?>
<?php 
if ($model->startdate != "" || $model->enddate != "") {
    
    $item_count = $model->printCertificatesReport($model->startdate,$model->enddate)->getTotalItemCount();    
    ?>
    <?php if ($item_count > 0) { ?>
        <a href="javascript:void(0);" id="printdiv" class="btn m-b-xs  btn-primary pull-right"> <i class="fa fa-print"></i>  Print</a>    
        <div class="col-lg-12 col-md-12">&nbsp;</div>
    <?php } ?>  
        <div id="Getprintval">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                
                <?php
                $startdate_disp = Myclass::date_dispformat($model->startdate);
                $enddate_disp = Myclass::date_dispformat($model->enddate);

                $gridColumns = array(
                    array(
                        'header' => 'Student Name',
                        'name' => 'dmvStudents.student_id',
                        'value' => function($data){
                                        echo $data->dmvStudents->first_name.' '.$data->dmvStudents->last_name;
                                    },
                    ),
                    array(
                        'header' => 'Agency Name',
                        'name' => 'dmvStudents.dmvAffiliateInfo.agency_name',
                        'value' => $data->dmvStudents->dmvAffiliateInfo->agency_name,
                    ),
                    array(
                        'header' => 'Instructor Name',
                        'name' => 'dmvStudents.dmvAffiliateInfo.affiliate_instructor.Instructor.ins_first_name',
                        'value' => function($data){
                                       echo PrintCertificate::model()->getInstructorName($data->dmvStudents->clas_id);
                                    },
                    ),
                    array(
                        'header' => 'Certificate Number',
                        'name' => 'certificate_number',
                        'value' => $data->certificate_number,
                    ),
                );
                $this->widget('booster.widgets.TbExtendedGridView', array(
                    //'filter' => $model,
                    'type' => 'striped bordered datatable',
                    'enableSorting' => false,
                    'dataProvider' => $model->printCertificatesReport($model->startdate,$model->enddate),
                    'extendedSummary' => array(
                        'columns' => array(
                            'number_of_books' => array('label' => 'Total Number of Books', 'class' => 'TbSumOperation')
                        )
                    ),
                    'responsiveTable' => true,
                    'template' => "<div class='panel panel-primary'>"
                    . "<div class='panel-heading'>"
                    . "<div class='pull-right'>{summary}</div>"
                    . "<h3 class='panel-title'>Certificate Report</h3></div>"
                    . "<div class='panel-body'><p>Total Number of Certificate From {$startdate_disp} until {$enddate_disp} is {$item_count} {extendedSummary}</p>  {items}{pager}</div></div>",
                    'columns' => $gridColumns
                        )
                );
                ?>
            </div>
        </div>  
      </div>       
<?php } ?>
<?php
$js = <<< EOD
$(document).ready(function(){        
        
   $("#print_res").click(function() {
        var startdate = $("#PrintCertificate_startdate").val();
        var enddate = $("#PrintCertificate_enddate").val();

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
        
    $("#printdiv").click(function() {   
        var innerContents = document.getElementById("Getprintval").innerHTML;
        var popupWinindow = window.open('', '_blank', 'width=600,height=700,scrollbars=yes,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
        popupWinindow.document.open();
        popupWinindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="/themes/adminlte/css/print.css" /></head><body onload="window.print()">' + innerContents + '</html>');    popupWinindow.document.close();  
    });      
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_cert_report', $js);
?>