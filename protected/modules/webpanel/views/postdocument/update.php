<?php
/* @var $this PostdocumentController */
/* @var $model PostDocument */

$this->title='Update Document ';
$this->breadcrumbs=array(
	'Documents'=>array('index'),
	'Update Document',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>