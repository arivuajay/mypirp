<?php
/* @var $this PaymentsController */
/* @var $model Payment */

$this->title='Edit Print Certificate';
$this->breadcrumbs=array(
	'Print Certificates'=>array('index'),
	'Edit Print Certificate',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','students')); ?>
</div>