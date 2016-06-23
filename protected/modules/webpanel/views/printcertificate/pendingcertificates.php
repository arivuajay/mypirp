<?php
/* @var $this PaymentsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Print Certificates Pending';
$this->breadcrumbs = array(
    'Print Certificates Pending',
);


$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
echo  $model->pnewclassid;
?>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search_pendingcerts', compact('model')); ?>


<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                     Generate student certificates
                </h3>
                <div class="clearfix"></div>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(                
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),               
            ));
            ?>
            <div class="box-body">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'pnewclassid', array('class' => 'col-sm-2 control-label')); ?>                   
                <div class="col-sm-5">
                    <?php echo $form->dropDownList($model, 'pnewclassid', $class_infos, array('class' => 'form-control', "empty" => "Select Class")); ?>         
                    <div style="display:none;" id="pnewclassid_error" class="errorMessage">Please choose class.</div>
                </div>    
            </div>
            </div>    
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton('Print Certificate' , array('class' => 'btn btn-success',"id"=>"pcertificate")); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$js = <<< EOD
$(document).ready(function(){         
  
    $('.year').datepicker({ dateFormat: 'yyyy' });
    $('.date').datepicker({ format: 'yyyy-mm-dd' });
      
    $("#pcertificate").click(function(){
        var classid = $("#DmvClasses_pnewclassid").val();
        $("#pnewclassid_error").hide();
        
        if(classid=="")
        {
            $("#pnewclassid_error").show();
            return false;
        }
        
        return true;
    });    
        
});
EOD;
Yii::app()->clientScript->registerScript('_form_pc', $js);
?>