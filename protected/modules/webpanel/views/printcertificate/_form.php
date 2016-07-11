<?php
/* @var $this PaymentsController */
/* @var $model Payment */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$class_id = Yii::app()->request->getQuery('id');
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'print-certificate-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', "target" => "_blank"),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));

            //
            ?>
            <div class="box-body">
                <?php if ($model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'student_id', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">            
                            <?php                           
                            echo $form->dropDownList($model, 'student_id', $students, array(
                                    'options' => Students::get_student_address_list($class_id),
                                    'data-live-search' => "true", 
                                    'class' => 'selectpicker form-control', 
                                    "empty" => "Select Student"
                                )
                            );
                            ?>
                            <?php echo $form->error($model, 'student_id'); ?>
                        </div>
                    </div>
                <?php }
                ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'notes', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'notes', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'notes'); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton('RePrint', array('class' => 'btn btn-primary', "id" => "reprint")); ?>
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
    $("#reprint").click(function(){
        var std_id = $("#PrintCertificate_student_id").val();        
        if(std_id!="")
        {
            setTimeout(function(){
                 document.getElementById("print-certificate-form").reset();
                 $("#PrintCertificate_student_id").val('').selectpicker('refresh');
            }, 2000);
        }    
    });       
});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>