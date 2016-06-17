<?php
/* @var $this DefaultController */
/* @var $model Admin */

$this->title = Myclass::t('APP26');
$this->breadcrumbs[] = $this->title;
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-6 col-xs-12">
        <!-- small box -->
        <div class="box box-primary">   
            <?php
            $form = $this->beginWidget('CActiveForm', array( 'id' => 'user-form',
                    'enableAjaxValidation' => true,
                    'clientOptions' => array(
                'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'role' => 'form'),
                ));
                ?>
                <?php echo $form->errorSummary(array($model)); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'password', array('class' => 'col-lg-4 col-sm-2 control-label' )); ?> 
                            <div class="col-lg-6">
                                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'current_password', array('class' => 'col-lg-4 col-sm-2 control-label')); ?>
                            <div class="col-lg-6">
                                <?php echo $form->passwordField($model, 'current_password', array('class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 're_password', array('class' => 'col-lg-4 col-sm-2 control-label')); ?>
                            <div class="col-lg-6">
                                <?php echo $form->passwordField($model, 're_password', array('class' => 'form-control')); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-4 col-lg-8">
                                <?php echo CHtml::submitButton("Reset", array('class' => 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?> 
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->
