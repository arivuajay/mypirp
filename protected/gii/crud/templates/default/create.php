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
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->title='Create $label';\n";
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$this->title,
);\n";
?>
?>

<div class="user-create">
    <?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>\n"; ?>
</div>
