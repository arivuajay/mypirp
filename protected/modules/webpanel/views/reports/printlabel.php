<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */
/* @var $form CActiveForm */


$this->title = 'Print labels';
$this->breadcrumbs = array(
    'Print labels',
);
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'method' => 'get',
                        'action' => array('/webpanel/reports/printlabels'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>                 
                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'startdate', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'startdate', array('class' => 'form-control date')); ?>                               
                            </div>   
                            <div style="display: none;" id="startdate_error" class="errorMessage">Please select start date.</div>
                        </div>
                    </div> 

                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'enddate', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'enddate', array('class' => 'form-control date')); ?>                               
                            </div> 
                            <div style="display: none;" id="enddate_error" class="errorMessage">Please select end date.</div>
                        </div>
                    </div> 
                    
                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'affiliate_id', array('class' => 'control-label')); ?>                   
                            <?php echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control selectpicker', "empty" => "ALL" ,"data-live-search"=>"true")); ?>         
                        </div>
                    </div> 
                    <div class="clearfix"></div>   
                    
                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'agencycode', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'agencycode', array('class' => 'form-control')); ?>
                        </div>
                    </div> 

                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'agencyname', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'agencyname', array('class' => 'form-control')); ?>
                        </div>
                    </div> 

                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filter', array("id" => 'print_res', 'class' => 'btn btn-primary form-control')); ?>
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
            
    $("#print_res").click(function() {
        var startdate = $("#Students_startdate").val();
        var enddate = $("#Students_enddate").val();

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
Yii::app()->clientScript->registerScript('_form_printlabel', $js);
?>
