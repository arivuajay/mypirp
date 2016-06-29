<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->title = 'View #' . $model->first_name;
$this->breadcrumbs = array(
    'Students' => array('index'),
    'View ' . 'Student',
);
?>
<div class="col-lg-8">
    <div class="user-view">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'htmlOptions' => array('class' => 'table table-striped table-bordered'),
            'attributes' => array(
                'first_name',
                'middle_name',
                'last_name',
                'stud_suffix',
                'address1',
                'address2',
                'city',
                'state',
                'zip',
                'phone',
                'email',
                'gender',
                array(
                    'name' => 'dob',
                    'type' => 'raw',
                    'value' => ($model->dob != "0000-00-00") ? Myclass::date_dispformat($model->dob) : "-"                    
                ),
                'licence_number',
                'notes',
                array(
                    'name' => 'course_completion_date',
                    'type' => 'raw',
                    'value' => ($model->course_completion_date != "0000-00-00") ? Myclass::date_dispformat($model->course_completion_date) : "-"                    
                ),
            ),
        ));
        ?>
    </div>
</div>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php
        if (Yii::app()->request->urlReferrer == "")
            echo CHtml::link('Back', array('students/index'), array('class' => 'btn btn-primary'));
        else
            echo CHtml::link('Back', Yii::app()->request->urlReferrer, array('class' => 'btn btn-primary'));
        ?>
    </div>
</div>