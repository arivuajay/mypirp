<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->title='Update $label: '. \$model->{$this->tableSchema->primaryKey};\n";
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Update $label',
);\n";
?>
?>

<div class="user-create">
    <?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
</div>