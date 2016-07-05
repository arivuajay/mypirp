<?php
/* @var $this MessagesController */
/* @var $model DmvPostMessage */

$this->title='Create Message';
$this->breadcrumbs=array(
	'Messages'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','affiliates'));?>
</div>
