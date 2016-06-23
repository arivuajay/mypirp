<?php
/* @var $this MessagesController */
/* @var $model DmvPostMessage */

$this->title='Update Message';
$this->breadcrumbs=array(
	'Messages'=>array('index'),
	'Update Message',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>