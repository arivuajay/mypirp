<?php
/* @var $this AffliatesController */
/* @var $model DmvAffiliateInfo */
/* @var $form CActiveForm */

$this->title = 'Create an affiliate';

$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;

$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
$country = Myclass::getallcountries();
?>
<!-- page content -->
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $this->title; ?></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">                  
            <div class="x_content"> 

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'dmv-affiliate-info-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'enableAjaxValidation' => false,
                ));
                ?>
                <div class="box-body">

                    <div class="form-group">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-5">
                            <?php echo $form->error($model, 'composite_error'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class='col-sm-2 control-label'>Client</label>
                        <div class="col-sm-5">
                            <?php echo $form->dropDownList($model, 'admin_id', $adminvals, array('class' => 'form-control')); ?> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'agency_code', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'agency_code', array('class' => 'form-control', 'size' => 3, 'maxlength' => 3)); ?>
                            <?php echo $form->error($model, 'agency_code'); ?>
                        </div>
                    </div>                                 

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'user_id', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'user_id', array('class' => 'form-control', 'size' => 60, 'maxlength' => 150)); ?>
                            <?php echo $form->error($model, 'user_id'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                    </div>   

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'agency_name', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'agency_name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 150)); ?>
                            <?php echo $form->error($model, 'agency_name'); ?>
                        </div>
                    </div>                   

                    <div class="form-group">
                        <?php echo $form->labelEx($refmodel, 'student_fee', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-dollar"></i></span>
                                <?php echo $form->textField($refmodel, 'student_fee', array('class' => 'form-control')); ?>
                            </div>    
                            <?php echo $form->error($refmodel, 'student_fee'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($refmodel, 'aff_book_fee', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-dollar"></i></span>
                                <?php echo $form->textField($refmodel, 'aff_book_fee', array('class' => 'form-control')); ?>
                            </div>    
                            <?php echo $form->error($refmodel, 'aff_book_fee'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($refmodel, 'referral_code', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($refmodel, 'referral_code', array('class' => 'form-control')); ?>
                            <?php echo $form->error($refmodel, 'referral_code'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($refmodel, 'referral_amt', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <?php echo $form->textField($refmodel, 'referral_amt', array('class' => 'form-control')); ?>
                            </div>    
                            <?php echo $form->error($refmodel, 'referral_amt'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'agency_approved_date', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'agency_approved_date', array('class' => 'form-control date')); ?>
                            </div> 
                            <?php echo $form->error($model, 'agency_approved_date'); ?>
                        </div> 
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-0 col-sm-offset-2">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
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
        
$('.year').datepicker({ dateFormat: 'yyyy' });
$('.date').datepicker({ format: 'yyyy-mm-dd' }); 
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_affiliate', $js);
?>