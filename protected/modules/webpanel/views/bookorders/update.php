<?php
/* @var $this BookordersController */
/* @var $model BookOrders */

$this->title='Update Book Order';
$this->breadcrumbs=array(
	'Book Orders'=>array('index'),
	'Update Book Order',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>