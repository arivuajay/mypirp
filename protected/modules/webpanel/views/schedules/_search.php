<?php
/* @var $this SchedulesController */
/* @var $model DmvClasses */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'clas_id'); ?>
		<?php echo $form->textField($model,'clas_id',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'affiliate_id'); ?>
		<?php echo $form->textField($model,'affiliate_id',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clas_date'); ?>
		<?php echo $form->textField($model,'clas_date',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clas_name'); ?>
		<?php echo $form->textField($model,'clas_name',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_time'); ?>
		<?php echo $form->textField($model,'start_time',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_time'); ?>
		<?php echo $form->textField($model,'end_time',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date2'); ?>
		<?php echo $form->textField($model,'date2',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_time2'); ?>
		<?php echo $form->textField($model,'start_time2',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_time2'); ?>
		<?php echo $form->textField($model,'end_time2',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'loc_addr'); ?>
		<?php echo $form->textField($model,'loc_addr',array('class'=>'form-control','size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'loc_city'); ?>
		<?php echo $form->textField($model,'loc_city',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'loc_state'); ?>
		<?php echo $form->textField($model,'loc_state',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'zip'); ?>
		<?php echo $form->textField($model,'zip',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'instructor_id'); ?>
		<?php echo $form->textField($model,'instructor_id',array('class'=>'form-control')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'show_admin'); ?>
		<?php echo $form->textField($model,'show_admin',array('class'=>'form-control','size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pending'); ?>
		<?php echo $form->textField($model,'pending',array('class'=>'form-control')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->