<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Book Orders Report';
$this->breadcrumbs = array(
    'Book Orders Report',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>
<?php $this->renderPartial('_search_bookorder', compact('model','affiliates')); ?>
<?php
if ($model->startdate != "" || $model->enddate != "") {
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
                        'header' => 'Agency Name',
                        'name' => 'affiliateInfo.agency_name',
                        'value' => $data->affiliateInfo->agency_name,
                    ),
                    'payment_date',
                    'number_of_books'
                );
                $this->widget('booster.widgets.TbExtendedGridView', array(
                    //'filter' => $model,
                    'type' => 'striped bordered datatable',
                    'enableSorting' => false,
                    'dataProvider' => $model->search(),
                    'extendedSummary' => array(
                        'columns' => array(
                            'number_of_books' => array('label' => 'Total Number of Books', 'class' => 'TbSumOperation')
                        )
                    ),
                    'responsiveTable' => true,
                    'template' => "<div class='panel panel-primary'>"
                    . "<div class='panel-heading'>"
                    . "<div class='pull-right'>{summary}</div>"
                    . "<h3 class='panel-title'>Book Orders Report</h3></div>"
                    . "<div class='panel-body'><p>Total Number of Book Orders From {$startdate} until {$enddate} is {$totalcount} {extendedSummary}</p>  {items}{pager}</div></div>",
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
        
$('.year').datepicker({ dateFormat: 'yyyy' });
$('.date').datepicker({ format: 'yyyy-mm-dd' }); 
        
   $("#print_res").click(function() {
        var startdate = $("#BookOrders_startdate").val();
        var enddate = $("#BookOrders_enddate").val();

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