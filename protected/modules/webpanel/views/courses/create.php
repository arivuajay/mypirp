<?php
/* @var $this CoursesController */
/* @var $model Courses */

$this->title='Create Course';
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
