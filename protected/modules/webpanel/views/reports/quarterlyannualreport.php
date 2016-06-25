<?php
/* @var $this SchedulesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Quarterly/Annual Report';
$this->breadcrumbs = array(
    'Quarterly/Annual Report',
);
$themeUrl = $this->themeUrl;

?>
<div class="col-lg-8 col-md-8 col-md-offset-2 col-lg-offset-2">
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
                <div class="col-lg-9 col-md-10 col-md-offset-1 col-lg-offset-1">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'newsmanagement-search-form',
                        'method' => 'get',
                        'action' => array('/webpanel/reports/exceldownload_quarterlyannual/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-8 col-md-8">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'quarterlyannual', array('class' => ' control-label')); ?>
                            <?php echo $form->dropDownList($model, 'quarterlyannual', array('Quarterly' => 'Quarterly', 'Annual' => 'Annual'), array('class' => 'form-control')); ?>           
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Export to CSV', array('id' => 'export_csv','class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <?php $this->endWidget(); ?>
                        <div class="col-lg-8 col-md-12">
                           <p>
                               <strong>Hint*</strong><br>
                               <span >Quarterly Report - &nbsp;Last 3 month from the current date</span><br>
                               <span>Annual Report &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- &nbsp;Last 12 month from the current date</span>
                           </p>
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
</div>
