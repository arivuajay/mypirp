<?php
/* @var $this MessagesController */
/* @var $model DmvPostMessage */

$this->title='Update Message: '. $model->message_id;
$this->breadcrumbs=array(
	'Dmv Post Messages'=>array('index'),
	'Update Dmv Post Messages',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?></div>