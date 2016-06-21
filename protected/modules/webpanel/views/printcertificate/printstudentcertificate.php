<?php
/* @var $this PaymentsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Print Certificates';
$this->breadcrumbs = array(
    'Print Certificates',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
?>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<h4><?php echo $class_info; ?></h4>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            array(
                'header' => 'Certificate Number',
                'name' => 'certificate_number',
                'htmlOptions' => array('style' => 'width: 180px;text-align:center', 'vAlign' => 'middle'),
                'value' => function($data) {
            echo "#028-0" . $data->certificate_number;
        }
            ),
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{view}',
                'buttons' => array(
                    'view' => array(
                        'url' => 'Yii::app()->controller->createUrl("printcertificate/certificatedisplay",array("id"=>$data->student_id))',
                        'options' => array("title" => "Print", "class" => "printcert")
                    ),
                ),
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            // 'filter' => $model,
            'type' => 'striped bordered datatable',
            'enableSorting' => false,
            'dataProvider' => $model->search($class_id),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Print Certificates</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>

<div id="Getprintval" style="display:none;"></div>
<?php
$js = <<< EOD
$(document).ready(function(){
         
    $(".printcert").click(function() {   
        var pcertificate_url = $(this).attr('href');
        var flag = 0;
        
        $.ajax({
                type: "POST",
                url: pcertificate_url,                
                cache: false,
                success: function(html){                       
                    $("#Getprintval").html(html);
                    flag = 1;                  
                }
             });
        
        setTimeout(function(){
            if(flag==1)
            {    
                var innerContents = document.getElementById("Getprintval").innerHTML;
                var popupWinindow = window.open('', '_blank', 'width=950,height=650,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
                popupWinindow.document.open();
                popupWinindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="/themes/adminlte/css/print.css" /></head><body onload="window.print()">' + innerContents + '</html>');    popupWinindow.document.close();  
                return false;    
            }
        }, 2000);    
         return false;   
    });
});
EOD;
Yii::app()->clientScript->registerScript('_form_pc', $js);
?>