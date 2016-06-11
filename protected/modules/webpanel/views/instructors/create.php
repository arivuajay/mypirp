<?php
/* @var $this InstructorsController */
/* @var $model DmvAddInstructor */

$this->title='Create Instructors';
$this->breadcrumbs=array(
	'Instructors'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','affiliates','x_aff')); ?>
</div>
