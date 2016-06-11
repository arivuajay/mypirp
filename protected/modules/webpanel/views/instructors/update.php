<?php
/* @var $this InstructorsController */
/* @var $model DmvAddInstructor */

$this->title = 'Update Instructor: ' . $model->instructor_last_name . " " . $model->ins_first_name;
$this->breadcrumbs = array(
    'Instructors' => array('index'),
    'Update Instructor',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model', 'affiliates','x_aff')); ?>
</div>