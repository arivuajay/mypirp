<?php
/* @var $this DefaultController */
/* @var $model Admin */

$this->title = Myclass::t('APP26');
$this->breadcrumbs[] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">          
            <div class="panel-body">
                <div class="position-left">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-form',
                        'enableAjaxValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'role' => 'form'),
                    ));
                    ?>
                    <?php echo $form->errorSummary(array($model)); ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'password', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'current_password', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo $form->passwordField($model, 'current_password', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 're_password', array('class' => 'col-lg-2 col-sm-2 control-label')); ?>
                        <div class="col-lg-10">
                            <?php echo $form->passwordField($model, 're_password', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <?php echo CHtml::submitButton("Reset", array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </section>
    </div>
</div>


