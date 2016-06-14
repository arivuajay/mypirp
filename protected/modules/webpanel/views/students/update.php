<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->title='Update Students: '. $model->student_id;
$this->breadcrumbs=array(
	'Students'=>array('index'),
	'Update Students',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>