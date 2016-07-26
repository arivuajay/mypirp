<?php
/* @var $this PaymentsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Generate certificates';
$this->breadcrumbs = array(
    'Generate Certificates Pending',
);
?>
<div class="col-lg-12 col-md-12">&nbsp;</div>
<?php $this->renderPartial('_search_pendingcerts', compact('model','adminvals')); ?>
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $this->title; ?></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-lg-12 col-xs-12">
         <div class="x_panel">                  
            <div class="x_content"> 
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
                        <?php echo CHtml::submitButton('Print Certificate' , array('class' => 'btn btn-success',"id"=>"pcertificate","name"=>"printcert")); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        </div>
    </div>
</div>    
<?php
$js = <<< EOD
$(document).ready(function(){    
        
    $("#pcertificate").on('click',function(){      
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