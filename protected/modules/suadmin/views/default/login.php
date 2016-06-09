<?php
$this->title = 'Sign In';
$this->breadcrumbs = array(
    $this->title
);
?>
<div>   
    <div class="login_wrapper">
        <div class="animate form login_form">
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
            <section class="login_content">
                <?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form')); ?>              
                <h1><?php echo $this->title; ?></h1>
                <div>         
                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', "placeholder" => "Username")); ?>
                    <?php echo $form->error($model, 'username') ?>
                </div>
                <div>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', "placeholder" => "Password")); ?>
                    <?php echo $form->error($model, 'password') ?>
                </div>
                <div>              
                    <?php echo $form->checkBox($model, 'rememberMe', array('id' => 'check', 'checked' => 'checked')); ?>
                    <?php echo ' Remember Me'; ?>
                </div>
                <div>
                    <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary submit', 'name' => 'sign_in')) ?>
                    <p style="text-align: center"><?php echo CHtml::link('Lost your password?', array('/suadmin/default/forgotpassword'), array("class" => "reset_pass")) ?></p>   
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    <div>
                        <h1><i class="fa fa-car"></i> MypirpClass!</h1>
                        <p>&copy;2016 All Rights Reserved.</p>
                    </div>

                </div>
                <?php $this->endWidget(); ?>
            </section>
        </div>
    </div>
</div>