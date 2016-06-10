<?php
/* @var $this AffliatesController */
/* @var $model DmvAffiliateInfo */

$this->title = 'Update Affiliate Info: ' . $model->agency_name;
$this->breadcrumbs = array(
    'Affiliate Infos' => array('index'),
    'Update Affiliate Info',
);
?>

<div class="user-create">
    <?php $this->renderPartial('_form',compact('model','refmodel')); ?>
</div>