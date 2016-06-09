<?php
$this->title = Myclass::t('APP27');
$this->breadcrumbs[] = $this->title;
?>
<div class="form-box" id="login-box">
    <div class="header"><?php echo CHtml::encode($this->title) ?></div>
    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form')); ?>
    <div class="body bg-gray">
        <?php if (isset($this->flashMessages)): ?>
            <?php foreach ($this->flashMessages as $key => $message) { ?>
                <div class="alert alert-<?php echo $key; ?> fade in">
                    <button type="button" class="close close-sm" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $message; ?>
                </div>
            <?php } ?>
        <?php endif ?>  
        <div class="form-group">
            <?php echo $form->labelEx($model, 'email') ?>
            <?php echo $form->textField($model, 'email', array('autofocus', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'email') ?>
        </div>
    </div>
    <div class="footer">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <?php echo CHtml::submitButton(Myclass::t('APP28'), array('class' => 'btn bg-olive btn-block', 'name' => 'forget_password')) ?>   
                </div>
                <div class="col-lg-6">
                    <?php echo CHtml::link('Cancel', array('/webpanel/default/login'),array('class' => 'btn bg-olive btn-block')) ?>
                </div>
            </div>    
       </div>     
    </div>
    <?php $this->endWidget(); ?>
</div>