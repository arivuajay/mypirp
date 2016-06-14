<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->title='Create Student';
$this->breadcrumbs=array(
	'Create Student'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','affiliates','classes'));?>
</div>
