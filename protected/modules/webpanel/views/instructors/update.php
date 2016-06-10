<?php
/* @var $this InstructorsController */
/* @var $model DmvAddInstructor */

$this->title='Update Instructor: '. $model->instructor_id;
$this->breadcrumbs=array(
	'Instructors'=>array('index'),
	'Update Instructor',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>