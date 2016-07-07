<?php
/* @var $this AffliatesController */
/* @var $model DmvAffiliateInfo */
/* @var $form CActiveForm */

$themeUrl = $this->themeUrl;
$country = Myclass::getallcountries();
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
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
                
                <?php if (!$model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'sponser_email', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'sponser_email', array('class' => 'form-control', "value" => "nadine@americansafetyinstitute.com")); ?>                           
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'sponsor_code', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'sponsor_code', array('class' => 'form-control', "value" => "28", "disabled" => "disabled")); ?>
                            <?php echo $form->error($model, 'sponsor_code'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'file_type', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'file_type', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100, "value" => "QTR", "disabled" => "disabled")); ?>
                            <?php echo $form->error($model, 'file_type'); ?>
                        </div>
                    </div>
                
                      <div class="form-group">
                        <?php echo $form->labelEx($model, 'email_addr', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'email_addr', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                            <?php echo $form->error($model, 'email_addr'); ?>
                        </div>
                    </div>

                <?php } ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'agency_code', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'agency_code', array('class' => 'form-control', 'size' => 3, 'maxlength' => 3)); ?>
                        <?php echo $form->error($model, 'agency_code'); ?>
                    </div>
                </div>
                <?php if (!$model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'record_type', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->dropDownList($model, 'record_type', array("A" => "Agency", "I" => "Instructor"), array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'record_type'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'trans_type', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->dropDownList($model, 'trans_type', array("X" => "No change", "A" => "Add", "I" => "Inactive", "M" => "Modify"), array('class' => 'form-control')); ?> 
                            <?php echo $form->error($model, 'trans_type'); ?>
                        </div>
                    </div>
                <?php } ?>                

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
                        <?php echo $form->textField($model, 'password', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'password'); ?>
                    </div>
                </div>   

                <?php if (!$model->isNewRecord) { ?>
                
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'ssn', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-4">
                            <?php echo $form->passwordField($model, 'ssn', array('class' => 'form-control', 'size' => 25, 'maxlength' => 25)); ?>
                            <?php echo $form->error($model, 'ssn'); ?>
                        </div>
                         <div class="col-sm-1">
                         <a href="javascript:void(0);" id="clickssn" data-toggle="tooltip" data-placement="right"  title="<?php echo $model->ssn;?>"><img src="<?php echo $themeUrl . '/img/preview.gif'; ?>"></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'fedid', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-4">
                            <?php echo $form->passwordField($model, 'fedid', array('class' => 'form-control', 'size' => 25, 'maxlength' => 25)); ?>                           
                            <?php echo $form->error($model, 'fedid'); ?>
                        </div>
                        <div class="col-sm-1">
                         <a href="javascript:void(0);"id="clickfed" data-toggle="tooltip" data-placement="right"  title="<?php echo $model->fedid;?>"><img src="<?php echo $themeUrl . '/img/preview.gif'; ?>"></a>
                        </div>
                    </div>
                <?php } ?>   
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'agency_name', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'agency_name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 150)); ?>
                        <?php echo $form->error($model, 'agency_name'); ?>
                    </div>
                </div>
                <?php if (!$model->isNewRecord) { ?>
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
                            <?php echo $form->textField($model, 'city', array('class' => 'form-control', 'size' => 25, 'maxlength' => 25)); ?>
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
                            <?php echo $form->textField($model, 'zip', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'zip'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'country_code', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->dropDownList($model, 'country_code', $country, array('class' => 'form-control', 'empty' => Myclass::t('Select County'))); ?>                          
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'last_name', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'last_name', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'last_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'first_name', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'first_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'initial', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'initial', array('class' => 'form-control', 'size' => 5, 'maxlength' => 5)); ?>
                            <?php echo $form->error($model, 'initial'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'contact_suffix', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'contact_suffix', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'contact_suffix'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'con_title', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'con_title', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'con_title'); ?>
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
                        <?php echo $form->labelEx($model, 'phone_ext', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'phone_ext', array('class' => 'form-control', 'size' => 15, 'maxlength' => 15)); ?>
                            <?php echo $form->error($model, 'phone_ext'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'fax', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'fax', array('class' => 'form-control', 'size' => 15, 'maxlength' => 15)); ?>
                            <?php echo $form->error($model, 'fax'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'owner_last_name', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'owner_last_name', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'owner_last_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'owner_first_name', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'owner_first_name', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'owner_first_name'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'owner_initial', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'owner_initial', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'owner_initial'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'owner_suffix', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textField($model, 'owner_suffix', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                            <?php echo $form->error($model, 'owner_suffix'); ?>
                        </div>
                    </div>


                <?php } ?>

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
                <?php if (!$model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'aff_notes', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $form->textArea($model, 'aff_notes', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                            <?php echo $form->error($model, 'aff_notes'); ?>
                        </div>
                    </div>
                    
                 <div class="form-group">
                        <?php echo $form->labelEx($model, 'enabled', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                             <?php echo $form->radioButtonList($model, 'enabled', array('Y' => 'Yes', 'N' => 'No'), array('separator' => ' ')); ?> 
                           
                        </div>
                    </div>
                <?php } ?>
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
    </div><!-- ./col -->
</div>
<?php
$js = <<< EOD
$(document).ready(function(){
        
    $("#clickfed").on('click',function(){
        var type = $("#DmvAffiliateInfo_fedid").attr("type");   
      
        if(type=="password")
        {
            $("#DmvAffiliateInfo_fedid").removeAttr("type");
        }else{
            $("#DmvAffiliateInfo_fedid").attr("type","password");
        }
    });    
      
    $("#clickssn").on('click',function(){
        var type = $("#DmvAffiliateInfo_ssn").attr("type");   
      
        if(type=="password")
        {
            $("#DmvAffiliateInfo_ssn").removeAttr("type");
        }else{
            $("#DmvAffiliateInfo_ssn").attr("type","password");
        }
    });     
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_affiliate', $js);
?>