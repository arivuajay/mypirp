<?php
/* @var $this CoursesController */
/* @var $model Courses */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'cid'); ?>
		<?php echo $form->textField($model,'cid',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ctitle'); ?>
		<?php echo $form->textField($model,'ctitle',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cshortdesc'); ?>
		<?php echo $form->textArea($model,'cshortdesc',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cdescription'); ?>
		<?php echo $form->textArea($model,'cdescription',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cdescription_list'); ?>
		<?php echo $form->textArea($model,'cdescription_list',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cprice'); ?>
		<?php echo $form->textArea($model,'cprice',array('class'=>'form-control','rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cimage'); ?>
		<?php echo $form->textField($model,'cimage',array('class'=>'form-control','size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cregisterurl'); ?>
		<?php echo $form->textField($model,'cregisterurl',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_at'); ?>
		<?php echo $form->textField($model,'modified_at',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->