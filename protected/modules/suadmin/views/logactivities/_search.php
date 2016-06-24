<?php
/* @var $this NewsManagementController */
/* @var $model NewsManagement */
/* @var $form CActiveForm */
?>
<div class="col-md-6 col-sm-6 col-lg-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Search</h2>            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <?php
            $totalcount = $model->search()->getTotalItemCount();
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'audit-search-form',
                'method' => 'get',
                'action' => array('/suadmin/logactivities/index/'),
                'htmlOptions' => array('role' => 'form')
            ));
            ?>
            <div class="col-lg-3 col-md-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'admin_id', array('class' => ' control-label')); ?>
                   <?php echo $form->dropDownList($model, 'admin_id', $adminvals, array('class' => 'form-control', "empty" => "ALL")); ?> 
                </div>
            </div> 

            <div class="col-lg-2 col-md-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'start_date', array('class' => ' control-label')); ?>
                    <div class="input-group">
                        <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                        <?php echo $form->textField($model, 'start_date', array('class' => 'form-control date')); ?>
                    </div>   
                </div>
            </div> 

            <div class="col-lg-2 col-md-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'end_date', array('class' => ' control-label')); ?>
                    <div class="input-group">
                        <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                        <?php echo $form->textField($model, 'end_date', array('class' => 'form-control date')); ?>
                    </div> 
                </div>
            </div> 

            <div class="col-lg-2 col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <?php echo CHtml::submitButton('Filter', array('class' => 'btn btn-primary form-control')); ?>                    
                </div>
            </div>
            <?php if($totalcount>0 && ($model->admin_id!="" || $model->start_date!="" || $model->end_date!="")) {?>
             <div class="col-lg-2 col-md-2">
                <div class="form-group">
                    <label>&nbsp;</label>                  
                     <?php echo CHtml::submitButton('Delete', array('class' => 'btn btn-danger form-control','onClick'=>'return confirm("Are you sure?");' ,"name"=>"deleteacts","id"=>"deleteacts"));                    
                     ?>
                </div>
            </div>
            <?php }?>
            <div class="clearfix"></div>                  
            <?php $this->endWidget(); ?>
             <?php if($totalcount>0 && ($model->admin_id!="" || $model->start_date!="" || $model->end_date!="")) {?>
            <p>Hint: Click the <strong>Delete</strong> button to delete all searched log activities.</p>
              <?php }?>
        </div>
    </div>
</div>