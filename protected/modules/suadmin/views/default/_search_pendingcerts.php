<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */
/* @var $form CActiveForm */
?>


<div class="page-title">
    <div class="title_left">
        <h3> <i class="glyphicon glyphicon-search"></i>  Search</h3>
    </div>                
</div>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <div class="x_panel">                  
            <div class="x_content"> 
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'pendingcerts-search-form',
                    'method' => 'get',
                    'action' => array('/suadmin/default/printcertificates/'),
                    'htmlOptions' => array('role' => 'form')
                ));
                ?>
                <div class="col-lg-3 col-md-3">
                    <div class="form-group">
                        <label class='control-label'>Client</label>
                        <?php echo $form->dropDownList($model, 'adminid', $adminvals, array('class' => 'form-control', "empty" => "ALL")); ?>                       
                    </div>
                </div>    

                <div class="col-lg-3 col-md-3">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'agencycode', array('class' => ' control-label')); ?>
                        <?php echo $form->textField($model, 'agencycode', array('class' => 'form-control')); ?>
                    </div>
                </div> 

                <div class="col-lg-3 col-md-3">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'clasdate', array('class' => ' control-label')); ?>                    
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                            <?php echo $form->textField($model, 'clasdate', array('class' => 'form-control date')); ?>
                        </div>  
                        (MM/DD/YYYY)
                    </div>
                </div> 

                <div class="col-lg-2 col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <?php echo CHtml::submitButton('Search Class', array('class' => 'btn btn-primary form-control')); ?>
                    </div>
                </div>
                <div class="clearfix"></div>                  
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

