<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Referral Report';
$this->breadcrumbs = array(
    'Referral Report',
);

$this->renderPartial('_search_referralreport', compact('model', 'refcodes'));

if ($model->startdate != "" || $model->enddate != "") {

    $startdate = Myclass::date_dispformat($model->startdate);
    $enddate = Myclass::date_dispformat($model->enddate);
    $totalcount = $model->search()->getTotalItemCount();
    ?>
    <?php if ($totalcount > 0) { ?>
        <a href="javascript:void(0);" id="printdiv" class="btn m-b-xs  btn-primary pull-right"> <i class="fa fa-print"></i>  Print</a>    
        <div class="col-lg-12 col-md-12">&nbsp;</div>
    <?php } ?>  
    <div class='col-xs-12 col-sm-4 col-md-3 col-lg-3 pull-right'>
        <div class='perpage pull-right'>
            Per Page: <?php echo CHtml::dropDownList('pageSize', $model->listperpage, Yii::app()->params['pageSizeOptions'], array('class' => 'change-pageSize')); ?>
        </div>
    </div>
    <div id="Getprintval">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <?php
                $gridColumns = array(
                    array(
                        'header' => 'Referral Code',
                        'name' => 'dmvClasses.Affliate.affiliateCommission.referral_code',
                        'value' => function($data) {
                            if ($data->dmvClasses->Affliate->affiliateCommission->referral_code != "")
                                echo $data->dmvClasses->Affliate->affiliateCommission->referral_code;
                            else
                                echo "-";
                        }
                    ),
                    array(
                        'header' => 'School name',
                        'name' => 'dmvClasses.Affliate.agency_name',
                        'value' => function($data) {
                            if ($data->dmvClasses->affiliate_id != "")
                                echo $data->dmvClasses->Affliate->agency_name;
                            else
                                echo "-";
                        }
                    ),
                    array(
                        'header' => 'School code',
                        'name' => 'dmvClasses.Affliate.agency_code',
                        'value' => function($data) {
                            if ($data->dmvClasses->affiliate_id != "")
                                echo $data->dmvClasses->Affliate->agency_code;
                            else
                                echo "-";
                        }
                    ),
                    array(
                        'header' => 'Total Students',
                        'name' => 'totalstudents',
                        'filter' => false,
                        'value' => function($data) {
                            echo Payment::totalstudents($data->class_id);
                        }
                    ),
                    array(
                        'header' => 'Referral Amt',
                        'name' => 'dmvClasses.Affliate.affiliateCommission.referral_amt',
                        'value' => function($data) {
                            if ($data->dmvClasses->Affliate->affiliateCommission->referral_amt != "")
                                echo $data->dmvClasses->Affliate->affiliateCommission->referral_amt;
                            else
                                echo "-";
                        }
                    ),
                    array(
                        'header' => 'Amount Due',
                        'filter' => false,
                        'name' => 'totaldue',
                        'value' => function($data) {
                            $totstuds = Payment::totalstudents($data->class_id);
                            $refamt = $data->dmvClasses->Affliate->affiliateCommission->referral_amt;
                            echo Payment::totaldue($totstuds, $refamt);
                        }
                    ),
                    array(
                        'header' => 'Class Date',
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
                );
                $this->widget('booster.widgets.TbExtendedGridView', array(
                    //'filter' => $model,
                    'type' => 'striped bordered datatable',
                    'enableSorting' => false,
                    'dataProvider' => $model->referal_report_search(),
                    'extendedSummary' => array(
                        'columns' => array(
                            'totalstudents' => array('label' => 'Total Students in this page', 'class' => 'TbSumOperation'),
                            'totaldue' => array('label' => 'Amount Due in this page ($)', 'class' => 'TbSumOperation')
                        )
                    ),
                    'responsiveTable' => true,
                    'template' => "<div class='panel panel-primary'>"
                    . "<div class='panel-heading'>"
                    . "<div class='pull-right'>{summary} </div>"
                    . "<h3 class='panel-title'>Referral Report</h3></div>"
                    . "<div class='panel-body'><p>From {$startdate} until {$enddate} {extendedSummary}</p> {items}{pager}</div></div>",
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

   $('.change-pageSize').on('change', function() {       
        var id=$(this).val();
        $("#listperpage").val(id);  
        $("#search-form").submit();  
    });
        
   $("#print_res").click(function() {
        var startdate = $("#Payment_startdate").val();
        var enddate = $("#Payment_enddate").val();

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
Yii::app()->clientScript->registerScript('_form_ref_report', $js);
?>