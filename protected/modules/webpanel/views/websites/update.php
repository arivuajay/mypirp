<?php
/* @var $this WebsitesController */
/* @var $model Websites */

$this->title='Update Website';
$this->breadcrumbs=array(
	'Websites'=>array('index'),
	'Update Website',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', array('model'=>$model, 'wcmodel' => $wcmodel,'list_wcmodel' => $list_wcmodel,'selected_keys' => $selected_keys)); ?></div>