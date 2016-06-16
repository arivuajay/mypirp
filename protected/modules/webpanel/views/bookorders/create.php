<?php
/* @var $this BookordersController */
/* @var $model BookOrders */

$this->title='Add Book Order';
$this->breadcrumbs=array(
	'Book Orders'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',compact('model','affiliates'));?>
</div>
