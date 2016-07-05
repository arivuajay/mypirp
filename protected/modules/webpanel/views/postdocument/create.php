<?php
/* @var $this PostdocumentController */
/* @var $model PostDocument */

$this->title='Add Document';
$this->breadcrumbs=array(
	'Document'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','affiliates')); ?>
</div>
