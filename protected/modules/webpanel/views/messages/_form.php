<?php
/* @var $this MessagesController */
/* @var $model DmvPostMessage */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'dmv-post-message-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'affiliate_id', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">
                        <?php
                        if ($model->isNewRecord)
                            echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control'));
                        else
                            echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control', "empty" => "Select One"));

                        echo $form->error($model, 'affiliate_id');
                        ?>
                    </div>    
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'message_title', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'message_title', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'message_title'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'descr', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'descr', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'descr'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'posted_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                            <?php echo $form->textField($model, 'posted_date', array('class' => 'form-control date')); ?>
                        </div> 
                        (MM/DD/YYYY)
                        <?php echo $form->error($model, 'posted_date'); ?>
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