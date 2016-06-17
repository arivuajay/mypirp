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
                        'id' => 'students-search-form',
                        'method' => 'get',
                        'action' => array('/affiliate/students/index/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'first_name', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'first_name', array('class' => 'form-control')); ?>
                        </div>
                    </div> 

                     <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'last_name', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'last_name', array('class' => 'form-control')); ?>
                        </div>
                    </div> 
                    
                     <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'licence_number', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'licence_number', array('class' => 'form-control')); ?>
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
