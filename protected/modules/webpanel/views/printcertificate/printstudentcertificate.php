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
  <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'print-certificate-form',
        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),               
    ));
    ?>
<?php
echo CHtml::submitButton("Print Selected", array('class' => 'marginleft btn btn-primary pull-right','id'=>'student-seleted'));
?>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<h4><?php echo $class_info; ?></h4>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
             array(
                'class' => 'CCheckBoxColumn',
                'selectableRows' => 2,
                'value' => '$data["student_id"]',
                'checkBoxHtmlOptions' => array("name" => "idList[]"),
                'htmlOptions' => array('style' => 'width: 10px;text-align:center'),
                'headerHtmlOptions'=>array('style' => 'width: 10px;text-align:center'),
            ),
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
<?php $this->endWidget(); ?>
<div id="Getprintval" style="display:none;"></div>
<?php
$js = <<< EOD
$(document).ready(function(){
        
    $("input:checkbox").attr('class', 'case');

     $('#yw0_c0_all').on('ifChecked', function(event){
             $('.case').iCheck('check');
     });
     $('#yw0_c0_all').on('ifUnchecked', function(event){
             $('.case').iCheck('uncheck');
     });  
        
    $('#student-seleted').on('click', function(){
      var idList    = $("input[type=checkbox]:checked").serialize();

      if(idList=="")
      {
        alert('Please select any one checkbox.');
        return false;
      }
      return true;
    });     
         
    $(".printcert").live("click",function() {   
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
                var popupWinindow = window.open('', '_blank', 'width=950,height=650,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,screenX=150,screenY=150,top=150,left=150');
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