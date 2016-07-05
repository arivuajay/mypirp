<?php
/* @var $this PostdocumentController */
/* @var $model PostDocument */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'post-document-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
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
                        <?php echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control')); ?>         
                        <?php echo $form->error($model, 'affiliate_id'); ?>
                    </div>    
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'doc_title', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'doc_title', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($model, 'doc_title'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'image', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->fileField($model, 'image'); ?>                         
                        <?php echo $form->error($model, 'image'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'posted_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                                                
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                            <?php echo $form->textField($model, 'posted_date', array('class' => 'form-control date')); ?>
                        </div> 
                        <?php echo $form->error($model, 'posted_date'); ?>
                    </div>                        
                </div>   

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>