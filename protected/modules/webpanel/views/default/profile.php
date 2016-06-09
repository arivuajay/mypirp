<?php
$this->title = Myclass::t('APP29');
$this->breadcrumbs = array(
    $this->title
);
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <!-- small box -->
        <div class="box box-primary">           
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'profile-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                    'enableAjaxValidation'=>true,
            )); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'username') ?>
                    <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'username') ?>
                </div>              
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'email') ?>
                    <?php echo $form->textField($model, 'email', array('autofocus', 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'email') ?>
                </div>
                
            </div><!-- /.box-body -->

            <div class="box-footer">
                <?php echo CHtml::submitButton(Myclass::t('APP25'), array('class' => 'btn btn-primary')) ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->