<?php
$this->title = 'Sign In';
$this->breadcrumbs = array(
    $this->title
);
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
        <p>Please fill out the following fields to login:</p>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'username') ?>
            <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'username') ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'password') ?>
            <?php echo $form->passwordField($model, 'password', array('autofocus', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'password') ?>
        </div>
        <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'check', 'checked' => 'checked')); ?>
        <?php echo ' Remember Me'; ?>
    </div>
    <div class="footer">
        <?php echo CHtml::submitButton('Login', array('class' => 'btn bg-olive btn-block', 'name' => 'sign_in')) ?>
        <p style="text-align: center"><?php echo CHtml::link('I forgot my password', array('/webpanel/default/forgotpassword')) ?></p>        
    </div>
    <?php $this->endWidget(); ?>
</div>