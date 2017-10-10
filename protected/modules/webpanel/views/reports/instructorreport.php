<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Instructor Report';
$this->breadcrumbs = array(
    'Instructor Report',
);
$themeUrl = $this->themeUrl;

?>
<div class="col-lg-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-file-excel-o"></i>  Instructor Report
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'method' => 'get',
                        'action' => array('/webpanel/reports/instructorreport'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'start_date', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'start_date', array('class' => 'form-control date')); ?>
                            </div>
                            (MM/DD/YYYY)
                            <div style="display: none;" id="startdate_error" class="errorMessage">Please select start date.</div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'end_date', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'end_date', array('class' => 'form-control date')); ?>
                            </div>
                            (MM/DD/YYYY)
                            <div style="display: none;" id="enddate_error" class="errorMessage">Please select end date.</div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'Affiliate', array('class' => 'control-label')); ?>
                            <?php echo $form->dropDownList($model, 'Affiliate', $affiliates, array('class' => 'form-control', "empty" => "ALL")); ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Export to CSV', array("id" => 'print_res', 'class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php $this->endWidget(); ?>
                </div>
            </section>
            
        </div>
    </div>
</div>

<?php
$js = <<< EOD
$(document).ready(function(){

     $("#print_resREMOVE").click(function() {
        var startdate = $("#DmvAddInstructor_start_date").val();
        var enddate = $("#DmvAddInstructor_end_date").val();

        $("#startdate_error").hide();    
        $("#enddate_error").hide();

       if(startdate=="")
        {
            $("#startdate_error").show();
            return false;
        }

       if(enddate=="")
        {
            $("#enddate_error").show();
            return false;
        }

        return true;

    }); 

});
EOD;
Yii::app()->clientScript->registerScript('_form_instructor', $js);
?>
