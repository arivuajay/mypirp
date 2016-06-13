<?php
/* @var $this SchedulesController */
/* @var $model DmvClasses */

$this->title='Update schedule: '. $model->clas_id;
$this->breadcrumbs=array(
	'Schedules'=>array('index'),
	'Update schedule',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>