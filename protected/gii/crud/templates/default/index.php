<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

<?php
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->title='$label';\n";
echo "\$this->breadcrumbs=array(
	'$label',
);\n";

echo "\$themeUrl = \$this->themeUrl;\n";
echo "\$cs = Yii::app()->getClientScript();\n";
echo "\$cs_pos_end = CClientScript::POS_END;\n\n";

echo "\$cs->registerScriptFile(\$themeUrl . '/js/datatables/jquery.dataTables.js', \$cs_pos_end);\n";
echo "\$cs->registerScriptFile(\$themeUrl . '/js/datatables/dataTables.bootstrap.js', \$cs_pos_end);\n";
?>
?>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo "<?php"; ?> echo CHtml::link('<i class="fa fa-plus"></i>&nbsp;&nbsp;Create <?php echo $this->modelClass; ?>', array('/admin/<?php echo strtolower($this->modelClass); ?>/create'), array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>

<div class="col-lg-12 col-md-12">&nbsp;</div>

<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo "<?php\n"; ?>
        $gridColumns = array(
        <?php
        $count = 0;
        $activeFields = $this->giiGenerateActiveInActiveFields();
        $restrict = $this->giiGenerateHiddenFields();
        foreach ($this->tableSchema->columns as $column) {
            if ($column->isPrimaryKey || in_array($column->name, $restrict))
                continue;
            if (++$count == 7)
                echo "\t\t/*\n";
            if (in_array($column->name, $activeFields)):
                $green = '<i class="fa fa-circle text-green"></i>';
                $red = '<i class="fa fa-circle text-red"></i>';
                echo "\t\tarray(
                'name' => 'Active',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle'),
                'type' => 'raw',
                'value' => function(\$data) {
                    echo (\$data->{$column->name} == 1) ? '{$green}' : '{$red}';
                },
            ),\n";
            else:
                echo "\t\t'" . $column->name . "',\n";
            endif;
        }
        if ($count >= 7)
            echo "\t\t*/\n";
        ?>
        array(
        'header' => 'Actions',
        'class' => 'booster.widgets.TbButtonColumn',
        'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
        'template' => '{view}{update}{delete}',
        )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
        'filter' => $model,
        'type' => 'striped bordered datatable',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  <?php echo $label ?></h3></div><div class="panel-body">{items}{pager}</div></div>',
        'columns' => $gridColumns
        )
        );
        ?>
    </div>
</div>