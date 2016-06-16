<?php
/* @var $this LeadersguideController */
/* @var $model LeadersGuide */

$this->title='Update Leaders Guide';
$this->breadcrumbs=array(
	'Leaders Guide'=>array('index'),
	'Update Leaders Guide',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>