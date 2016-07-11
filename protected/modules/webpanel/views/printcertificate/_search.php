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
                    <i class="glyphicon glyphicon-search"></i>  Search
                </h3>
                <div class="clearfix"></div>
            </div>

            <section class="content">
                <div class="row">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'printcertificate-search-form',
                        'method' => 'get',
                        'action' => array('/webpanel/printcertificate/index/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                  <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'affcode', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'affcode', array('class' => 'form-control')); ?>
                        </div>
                    </div> 

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'start_date', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'start_date', array('class' => 'form-control date')); ?>
                            </div>   
                            (MM/DD/YYYY)
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
                        </div>
                    </div> 

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Filter', array('class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>                  
                    <?php $this->endWidget(); ?>
                </div>
            </section>
        </div>
    </div>
</div>
