<?php
/* @var $this WebsitesController */
/* @var $model Websites */

$this->title='Create Website';
$this->breadcrumbs=array(
	'Websites'=>array('index'),
	$this->title,
);

//$books = CHtml::listData(Book::model()->findAll(), 'id', 'name');
//$selected_keys = array_keys(CHtml::listData( $model->books, 'id' , 'id'));
//echo CHtml::checkBoxList('Author[books][]', $selected_keys, $books);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model, 'wcmodel' => $wcmodel)); ?>
</div>
