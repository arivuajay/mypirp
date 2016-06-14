<?php
/* @var $this StudentsController */
/* @var $model Students */

$this->title='View #'.$model->student_id;
$this->breadcrumbs=array(
	'Students'=>array('index'),
	'View '.'Students',
);
?>
<div class="user-view">
    
    <p>
        <?php        $this->widget(
                'booster.widgets.TbButton', array(
                    'label' => 'Update',
                    'url' => array('update', 'id' =>  $model->student_id ),
                    'buttonType' => 'link',
                    'context' => 'primary',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'application.components.MyTbButton', array(
                    'label' => 'Delete',
                    'url' => array('delete', 'id' =>  $model->student_id ),
                    'buttonType' => 'link',
                    'context' => 'danger',
                    'htmlOptions' => array('confirm' => 'Are you sure you want to delete this item?'),
                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        echo "&nbsp;&nbsp;";
        $this->widget(
                'booster.widgets.TbButton', array(
            'label' => 'Download',
            'url' => array('view', 'id' =>  $model->student_id , 'export' => 'PDF'),
            'buttonType' => 'link',
            'context' => 'warning',
//                    'visible' => UserIdentity::checkAccess(Yii::app()->user->name)
                )
        );
        ?>
    </p>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
        'htmlOptions' => array('class'=>'table table-striped table-bordered'),
	'attributes'=>array(
		'student_id',
		'affiliate_id',
		'clas_id',
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
		'dob',
		'licence_number',
		'notes',
		'course_completion_date',
	),
)); ?>
</div>



