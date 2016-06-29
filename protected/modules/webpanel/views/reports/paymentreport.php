<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Payment Report';
$this->breadcrumbs = array(
    'Payment Report',
);

$this->renderPartial('_search_paymentreport', compact('model', 'affiliates'));

if ($model->startdate != "" || $model->enddate != "") {
    $startdate = Myclass::date_dispformat($model->startdate);
    $enddate = Myclass::date_dispformat($model->enddate);
    $totalcount = $model->search()->getTotalItemCount();

    if ($totalcount > 0) {
        ?>
        <a href="javascript:void(0);" id="printdiv" class="btn m-b-xs  btn-primary pull-right"> <i class="fa fa-print"></i>  Print</a>    
        <div class="col-lg-12 col-md-12">&nbsp;</div>
    <?php } ?>  
    <div id="Getprintval">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <?php
                $gridColumns = array(
                    array(
                        'header' => 'Agency Name',
                        'name' => 'dmvClasses.Affliate.agency_name',
                        'value' => $data->dmvClasses->Affliate->agency_name,
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
                    'total_students',
                    'payment_amount'
                );
                $this->widget('booster.widgets.TbExtendedGridView', array(
                    //'filter' => $model,
                    'type' => 'striped bordered datatable',
                    'enableSorting' => false,
                    'dataProvider' => $model->search(),
                    'extendedSummary' => array(
                        'columns' => array(
                            'payment_amount' => array('label' => 'Total amount received in this page', 'class' => 'TbSumOperation')
                        )
                    ),
                    'responsiveTable' => true,
                    'template' => "<div class='panel panel-primary'>"
                    . "<div class='panel-heading'>"
                    . "<div class='pull-right'>{summary}</div>"
                    . "<h3 class='panel-title'>Payment Report</h3></div>"
                    . "<div class='panel-body'><p>Payment Received From {$startdate} until {$enddate} {extendedSummary}</p>  {items}{pager}</div></div>",
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
Yii::app()->clientScript->registerScript('_form_preport', $js);
?>