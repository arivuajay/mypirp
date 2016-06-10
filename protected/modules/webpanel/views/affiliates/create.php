<?php
/* @var $this AffliatesController */
/* @var $model DmvAffiliateInfo */

$this->title='Create Affiliate';
$this->breadcrumbs=array(
	'Affiliate Infos'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form', compact('model','refmodel')); ?>
</div>
