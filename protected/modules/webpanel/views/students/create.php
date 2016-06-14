<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->title='Create Students';
$this->breadcrumbs=array(
	'Students'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
