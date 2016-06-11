<?php
/* @var $this InstructorsController */
/* @var $model DmvAddInstructor */
/* @var $form CActiveForm */
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'dmv-add-instructor-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Affiliate', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <?php                       
                        $htmlOptions = array('size' => '5', 'multiple' => 'true', 'id' => 'MasterSelectBox', 'class' => 'form-control', 'options' => $x_aff);
                        echo $form->listBox($model, 'Affiliate', $affiliates, $htmlOptions);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'ins_first_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'ins_first_name', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'ins_first_name'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'instructor_initial', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'instructor_initial', array('class' => 'form-control', 'size' => 5, 'maxlength' => 5)); ?>
                        <?php echo $form->error($model, 'instructor_initial'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'instructor_last_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'instructor_last_name', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'instructor_last_name'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'instructor_suffix', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'instructor_suffix', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'instructor_suffix'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'instructor_ss', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'instructor_ss', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'instructor_ss'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'instructor_code', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'instructor_code', array('class' => 'form-control', 'size' => 10, 'maxlength' => 4)); ?>
                        <?php echo $form->error($model, 'instructor_code'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'instructor_client_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'instructor_client_id', array('class' => 'form-control', 'size' => 11, 'maxlength' => 11)); ?>
                        <?php echo $form->error($model, 'instructor_client_id'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'instructor_dob', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                            <?php echo $form->textField($model, 'instructor_dob', array('class' => 'form-control date')); ?>
                        </div> 
                        <?php echo $form->error($model, 'instructor_dob'); ?>
                    </div>
                </div>
                
                 <div class="form-group">
                        <?php echo $form->labelEx($model, 'gender', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->dropDownList($model, 'gender', array( "" => "-Select One-","M" => "Male", "F" => "Female"), array('class' => 'form-control')); ?> 
                            <?php echo $form->error($model, 'gender'); ?>
                        </div>
                    </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'addr1', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'addr1', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($model, 'addr1'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'addr2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'addr2', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($model, 'addr2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'city', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'city', array('class' => 'form-control', 'size' => 30, 'maxlength' => 30)); ?>
                        <?php echo $form->error($model, 'city'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'state', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'state', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'state'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'zip', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'zip', array('class' => 'form-control', 'size' => 15, 'maxlength' => 15)); ?>
                        <?php echo $form->error($model, 'zip'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'size' => 15, 'maxlength' => 15)); ?>
                        <?php echo $form->error($model, 'phone'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'enabled', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->radioButtonList($model, 'enabled', array('Y' => 'Yes', 'N' => 'No'), array('separator' => ' ')); ?> 
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
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
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>