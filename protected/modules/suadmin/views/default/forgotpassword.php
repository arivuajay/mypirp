<?php
$this->title = Myclass::t('APP27');
$this->breadcrumbs[] = $this->title;
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
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', "placeholder" => "Email")); ?>
                    <?php echo $form->error($model, 'email') ?>
                </div>               
                <div>
                    <?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary submit', 'name' => 'sign_in')) ?>
                    <p style="text-align: center"><?php echo CHtml::link('Cancel', array('/suadmin/default/login'),array('class' => 'forget_pass')) ?></p>                    
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