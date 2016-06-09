<?php
$this->title = Myclass::t('APP29');
$this->breadcrumbs = array(
    $this->title
);
?>
<!-- page content -->
<div class="page-title">
    <div class="title_left">
        <h3>Edit Profile</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">                  
            <div class="x_content">                   
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'profile-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal form-label-left'),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'enableAjaxValidation' => true,
                ));
                ?>    
                <div class="form-group">                                
                    <?php echo $form->labelEx($model, 'username', array("class" => "col-lg-2 col-sm-2 control-label required")) ?>
                    <div class="col-lg-6">                                   
                        <?php echo $form->textField($model, 'username', array('autofocus', 'class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'username') ?>
                    </div>
                </div>
                <div class="form-group">                                
                    <?php echo $form->labelEx($model, 'email', array("class" => "col-lg-2 col-sm-2 control-label required")) ?>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6">                                   
                        <?php echo $form->textField($model, 'email', array('autofocus', 'class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'email') ?>
                    </div>
                </div>                          
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">     
                        <?php echo CHtml::submitButton(Myclass::t('APP25'), array('class' => 'btn btn-primary')) ?>                                
                        <?php echo CHtml::link('Cancel', array('/suadmin/default/index'), array("class" => "btn btn-default")) ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->