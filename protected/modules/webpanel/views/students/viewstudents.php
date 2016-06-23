<?php
/* @var $this StudentsController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'View/Edit Students';
$this->breadcrumbs = array(
    'Manage Students' => array('students/managestudents'),
    'View/Edit Students',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
?>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <h4><?php echo date("F d,Y", strtotime($model->dmvClasses->clas_date)) . " " . $model->dmvClasses->start_time . " to " . $model->dmvClasses->end_time; ?></h4>
    </div>
</div>


<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        $gridColumns = array(
            'first_name',
            'middle_name',
            'last_name',
            'city',
            'phone',
            'email',
            array(
                'header' => 'Gender',
                'name' => 'gender',
                'value' => function($data) {
                    if ($data->gender == "M")
                        echo "Male";
                    elseif ($data->gender == "F")
                        echo "Female";
                    else
                        echo "-";
                }
            ),
            'licence_number',
            array(
                'header' => 'Actions',
                'class' => 'booster.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 180px;;text-align:center', 'vAlign' => 'middle', 'class' => 'action_column'),
                'template' => '{update}&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' => array(
                    'update' => array('visible' => "AdminIdentity::checkAccess('webpanel.students.update')"),
                    'delete' => array('visible' => "AdminIdentity::checkAccess('webpanel.students.delete')"),
                ),
                'visible' => $this->checkVisible($print_certificate) //custom function
            )
        );

        $this->widget('booster.widgets.TbExtendedGridView', array(
            //  'filter' => $model,
            'type' => 'striped bordered datatable',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => '<div class="panel panel-primary"><div class="panel-heading"><div class="pull-right">{summary}</div><h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Students</h3></div><div class="panel-body">{items}{pager}</div></div>',
            'columns' => $gridColumns
                )
        );
        ?>
    </div>
</div>