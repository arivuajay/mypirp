<?php
/* @var $this SchedulesController */
/* @var $model DmvClasses */

$this->title='Create Schedule';
$this->breadcrumbs=array(
	'Schedules'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
