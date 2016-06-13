<?php
/* @var $this SchedulesController */
/* @var $model DmvClasses */

$this->title='Add Schedule';
$this->breadcrumbs=array(
	'Schedules'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',compact('model','affiliates','instructors'));?>
</div>
