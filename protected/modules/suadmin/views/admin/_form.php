<?php
/* @var $this AdminController */
/* @var $model Admin */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'admin-form',
    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => true,
        ));
?>
<div class="box-body">                 

    <div class="form-group">
        <?php echo $form->labelEx($model, 'username', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-5">
            <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
    </div>


    <div class="form-group">
        <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-5">
            <?php echo $form->textField($model, 'password', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>                

    <div class="form-group">
        <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-5">
            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'client_name', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-5">
            <?php echo $form->textField($model, 'client_name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'client_name'); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'domain_url', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-5">
            <?php echo $form->textField($model, 'domain_url', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'domain_url'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class='col-sm-2 control-label'>Permissions</label>
        <div class="col-sm-5">
            <?php $this->beginWidget('ext.ECheckBoxTree.ECheckBoxTree') ?>
            <?php foreach ($resources as $items): 
                $checked1 = "unchecked"; 
                $checked2 = "unchecked"; 
                if($model->isNewRecord){ 
                    $checked1 = "checked";                    
                }elseif (in_array($items->resource_id, $existing_resource)) {
                    $checked1 = "checked";                    
                }
                ?>
                <li><input name="resource_id[]" value="<?php echo $items->resource_id; ?>" type="checkbox" <?php echo $checked1;?> /><?php echo $items->resource_name; ?>
                    <?php if (isset($items->Childs)): ?>
                        <ul>
                            <?php foreach ($items->Childs as $sub_items):                               
                                if($model->isNewRecord){ 
                                    $checked2 = "checked";                    
                                }elseif (in_array($sub_items->resource_id, $existing_resource)) {
                                    $checked2 = "checked";                    
                                }
                                ?>
                                <li><input  name="resource_id[]" value="<?php echo $sub_items->resource_id; ?>" type="checkbox" <?php echo $checked2;?>/><?php echo $sub_items->resource_name; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>     
            <?php endforeach; ?>
            <?php $this->endWidget() ?>
        </div>
    </div>
    <?php
    if (!$model->status) {
        $model->status = 0;
    }
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-5">
            <?php echo $form->radioButtonList($model, 'status', array('1' => 'Oui', '0' => 'Non'), array('separator' => ' ')); ?> 
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>               

</div><!-- /.box-body -->

<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-0 col-sm-offset-2">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
            <?php echo CHtml::link('Cancel', array('/suadmin/admin'), array("class" => "btn btn-default")) ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
  