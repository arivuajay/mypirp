<?php
/* @var $this PaymentsController */
/* @var $model Payment */

$this->title='Add Payment';
$this->breadcrumbs=array(
	'Payments'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model', 'affiliates','schedules','delete_schedules')); ?>
</div>
