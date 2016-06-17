<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->title='Update Student: '. $model->first_name;
$this->breadcrumbs=array(
	'Students'=>array('index'),
	'Update Student',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>