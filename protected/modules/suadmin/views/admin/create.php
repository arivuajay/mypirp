<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->title = 'Create Admin';
$this->breadcrumbs = array(
    'Administration' => array('index'),
    $this->title,
);
?>
<!-- page content -->
<div class="page-title">
    <div class="title_left">
        <h3><?php echo $this->title;?></h3>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">                  
            <div class="x_content"> 
                <?php $this->renderPartial('_form', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</div>
