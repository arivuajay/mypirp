<?php
/* @var $this PaymentsController */
/* @var $model Payment */

$this->title='Update Payment';
$this->breadcrumbs=array(
	'Payments'=>array('index'),
	'Update Payment',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>