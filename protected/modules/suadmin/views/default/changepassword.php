<?php
/* @var $this DefaultController */
/* @var $model Admin */

$this->title = Myclass::t('APP26');
$this->breadcrumbs[] = $this->title;
?>
<div class="page-title">
    <div class="title_left">
        <h3>Change Password</h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">                  
            <div class="x_content">       
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'user-form',
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left', 'role' => 'form'),
                ));
                ?>
                <?php echo $form->errorSummary(array($model)); ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                    <div class="col-lg-6">
                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'current_password', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                    <div class="col-lg-6">
                        <?php echo $form->passwordField($model, 'current_password', array('class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 're_password', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                    <div class="col-lg-6">
                        <?php echo $form->passwordField($model, 're_password', array('class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <?php echo CHtml::submitButton("Reset", array('class' => 'btn btn-primary')); ?>
                        <?php echo CHtml::link('Cancel', array('/suadmin/default/index'), array("class" => "btn btn-default")) ?>
                    </div>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>       
    </div>
</div>


