<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'" . $this->class2id($this->modelClass) . "-form',
        'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
	'enableAjaxValidation'=>true,
)); ?>\n"; ?>
            <div class="box-body">
                <?php
                $restrict = $this->giiGenerateHiddenFields();
                foreach ($this->tableSchema->columns as $column) {
                    if ($column->autoIncrement || in_array($column->name, $restrict))
                        continue;
                    ?>
                    <div class="form-group">
                        <?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
                        <div class="col-sm-5">
                        <?php echo "<?php echo " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
                        <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save', array('class' => \$model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>\n"; ?>
                    </div>
                </div>
            </div>
            <?php echo "<?php \$this->endWidget(); ?>\n"; ?>
        </div>
    </div><!-- ./col -->
</div>