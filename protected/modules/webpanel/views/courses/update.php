<?php
/* @var $this CoursesController */
/* @var $model Courses */

$this->title='Update Course: '. $model->ctitle_en;
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	'Update Course',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model, 'choices_en' => $choices_en, 'choices_es' => $choices_es,)); ?></div>