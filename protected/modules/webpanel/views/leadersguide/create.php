<?php
/* @var $this LeadersguideController */
/* @var $model LeadersGuide */

$this->title='Create Leaders Guide';
$this->breadcrumbs=array(
	'Leaders Guide'=>array('index'),
	$this->title,
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',compact('model','affiliates'));?>
</div>
