<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */
/* @var $form CActiveForm */
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-file-excel-o"></i>  Export to CSV
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'newsmanagement-search-form',
                        'method' => 'get',
                        'action' => array('/webpanel/affiliates/exceldownload/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'start_date', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'start_date', array('class' => 'form-control date',"readonly"=>"readonly")); ?>
                            </div>  
                            <div style="display: none;" id="startdate_error" class="errorMessage">Please select start date.</div>
                        </div>
                    </div> 

                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'end_date', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'end_date', array('class' => 'form-control date',"readonly"=>"readonly")); ?>
                            </div> 
                            <div style="display: none;" id="enddate_error" class="errorMessage">Please select end date.</div>
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Export to CSV', array('id' => 'export_csv','class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    
                    
                    <?php $this->endWidget(); ?>
                </div>
            </section>
            
        </div>
    </div>
</div>
