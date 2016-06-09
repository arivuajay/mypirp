<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->title='Create Admin';
$this->breadcrumbs=array(
	'Administration'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
