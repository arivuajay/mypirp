<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Referral Report';
$this->breadcrumbs = array(
    'Referral Report',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>
<?php $this->renderPartial('_search_referralreport', compact('model', 'refcodes')); ?>
<?php
//if ($model->startdate != "" || $model->enddate != "") {
$startdate = date("m/d/Y", strtotime($model->startdate));
$enddate = date("m/d/Y", strtotime($model->enddate));

$totalcount = $model->search()->getTotalItemCount();
?>
<?php if ($totalcount > 0) { ?>
    <a href="javascript:void(0);" id="printdiv" class="btn m-b-xs  btn-primary pull-right"> <i class="fa fa-print"></i>  Print</a>    
    <div class="col-lg-12 col-md-12">&nbsp;</div>
<?php } ?>  
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
                'payment_date'
            );
            $this->widget('booster.widgets.TbExtendedGridView', array(
                //'filter' => $model,
                'type' => 'striped bordered datatable',
                'enableSorting' => false,
                'dataProvider' => $model->referal_report_search(),
                'extendedSummary' => array(
                    'columns' => array(
                        'totalstudents' => array('label' => 'Total Students', 'class' => 'TbSumOperation'),
                        'totaldue' => array('label' => 'Amount Due in $', 'class' => 'TbSumOperation')
                    )
                ),
                'responsiveTable' => true,
                'template' => "<div class='panel panel-primary'>"
                . "<div class='panel-heading'>"
                . "<div class='pull-right'>{summary}</div>"
                . "<h3 class='panel-title'>Book Orders Report</h3></div>"
                . "<div class='panel-body'><p>{extendedSummary}</p> {items}{pager}</div></div>",
                'columns' => $gridColumns
                    )
            );
            ?>
        </div>
    </div>  
</div>       
<?php //} ?>
<?php
$js = <<< EOD
$(document).ready(function(){
        
$('.year').datepicker({ dateFormat: 'yyyy' });
$('.date').datepicker({ format: 'yyyy-mm-dd' }); 
        
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
        var popupWinindow = window.open('', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
        popupWinindow.document.open();
        popupWinindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="/themes/adminlte/css/print.css" /></head><body onload="window.print()">' + innerContents + '</html>');    popupWinindow.document.close();  
    });      
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>