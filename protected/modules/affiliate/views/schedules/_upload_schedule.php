<?php
/* @var $this SchedulesController */
/* @var $model DmvClasses */

$this->title = 'Upload Schedules';
$this->breadcrumbs = array(
    'Schedules' => array('index'),
    $this->title,
);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'upload-schedule-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            ));
            ?>
            <div class="box-body">

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'scheduledoc', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->fileField($model, 'scheduledoc'); ?>
                        <?php echo $form->error($model, 'scheduledoc'); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton('Upload', array('class' => 'btn btn-success')); ?>
                    </div>
                </div>
                <h4><span style="color:red;font-weight: bold;">Hints:</span></h4>                   
                <ul>
                    <li>Please use the given excelsheet format ( Example: <a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl("/uploads/affiliate_schedules/Aff_Schedules.xls");?>">Sample Schedule Excel Sheet Format</a> )</li>
                    <li>Please fill the list of mandatory fields for each schedule. (INS_CODE, DATE, START_TIME, END_TIME, LOCATION, CITY, STATE, COUNTRY_CODE)</li>
                     <li>Please fill the START_TIME and END_TIME using this syntax. Example: <strong>11:00 am</strong> (Need space between time and the meridians)</li>
                    <li>Please give your respective instructor code.</li>
                    <li>Please use the given "Country Code" from the CSV file ( Download : <a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl("/uploads/country.csv");?>">Country Code Formats</a> )</li>
                </ul>                
            </div>
            <?php $this->endWidget(); ?>
            
        </div>        
    </div><!-- ./col -->
</div>