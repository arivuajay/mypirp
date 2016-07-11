<?php
/* @var $this PaymentsController */
/* @var $model Payment */
/* @var $form CActiveForm */
$cardtypes = Myclass::card_types();
$themeUrl = $this->themeUrl;

?>
<?php if ($model->isNewRecord) { ?>
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
                        'id' => 'instructors-search-form',
                        'method' => 'get',
                        'action' => array('/webpanel/payments/create/'),
                        'htmlOptions' => array('role' => 'form')
                    ));
                    ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'affcode', array('class' => ' control-label')); ?>
                            <?php echo $form->textField($model, 'affcode', array('class' => 'form-control')); ?>
                             <div class="errorMessage" id="err_affcode" style="display: none;">Please give agency code.</div>
                        </div>
                    </div> 
                    
                      <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'classdate', array('class' => ' control-label')); ?>
                            <div class="input-group">
                                <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                                <?php echo $form->textField($model, 'classdate', array('class' => 'form-control date')); ?>
                            </div> 
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <?php echo CHtml::submitButton('Search Class', array("id" => 'searchclass', "name"=>"searchclass" , 'class' => 'btn btn-primary form-control')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>                  
                    <?php $this->endWidget(); ?>
                </div>
            </section>

        </div>
    </div>
</div>
<?php }?>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
            'id' => 'payment-form',
            'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),            
            ));
            ?>
            <div class="box-body">
                <?php if ($model->isNewRecord) { ?>
                   <?php echo $form->hiddenField($model, 'affiliatesid'); ?>
<!--                <div class="form-group">
                    <?php //echo $form->labelEx($model, 'affiliatesid', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5"> 
                        <?php //echo $form->dropDownList($model, 'affiliatesid', $affiliates, array('class' => 'form-control', "empty" => "Select Agency")); ?>
                        <?php //echo $form->error($model, 'affiliatesid'); ?>
                    </div>
                </div>-->
                <?php }
                ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'class_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php if ($model->isNewRecord){ ?>
                        <?php echo $form->dropDownList($model, 'class_id', $schedules, array('class' => 'form-control', "empty" => "Select Class")); ?>
                        <?php }else{
                           echo Myclass::date_dispformat($model->dmvClasses->clas_date)." ".$model->dmvClasses->start_time." TO ".$model->dmvClasses->end_time;
                        }?>
                        <?php echo $form->error($model, 'class_id'); ?>
                    </div>
                     <div id="LoadingImage1" style="display: none"><img src="<?php echo $themeUrl;?>/img/loading.gif" /></div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                            <?php echo $form->textField($model, 'payment_date', array('class' => 'form-control date')); ?>
                        </div> 
                        <?php echo $form->error($model, 'payment_date'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_amount', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-dollar"></i></span>
                            <?php echo $form->textField($model, 'payment_amount', array('class' => 'form-control')); ?>
                        </div>       
                        (Example: 300.00)
                        <?php echo $form->error($model, 'payment_amount'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'total_students', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'total_students', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'total_students'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_type', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'payment_type', $cardtypes, array('class' => 'form-control', "empty" => "Select One")); ?>
                        <?php echo $form->error($model, 'payment_type'); ?>
                    </div>
                </div>

                <div class="form-group" style="display:none;" id="chequenumber">
                    <?php echo $form->labelEx($model, 'cheque_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'cheque_number', array('class' => 'form-control', 'size' => 15, 'maxlength' => 15)); ?>
                        <?php echo $form->error($model, 'cheque_number'); ?>
                    </div>
                </div>

                <div class="form-group" style="display:none;" id="moneyordernumber">
                    <?php echo $form->labelEx($model, 'moneyorder_number', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'moneyorder_number', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'moneyorder_number'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_complete', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php $chck = ($model->payment_complete=="Y")?"checked":"";                       
                              echo $form->checkBox($model, 'payment_complete', array('class' => 'form-control','checked'=>$chck)); ?>
                        <?php echo $form->error($model, 'payment_complete'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_notes', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textArea($model, 'payment_notes', array('class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'payment_notes'); ?>
                    </div>
                </div>

            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',"name"=>"paymentclass")); ?>
                    </div>
                </div>
            </div>
            
            <?php if ($model->isNewRecord) { ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'class_id_payments', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'class_id_payments', $delete_schedules, array('class' => 'form-control', "empty" => "Select Class")); ?>
                        <div class="errorMessage" id="err_class_id_payments" style="display: none;">Please select any class.</div>
                    </div>
                    <div id="LoadingImage2" style="display: none"><img src="<?php echo $themeUrl;?>/img/loading.gif" /></div>
                </div>
                <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-2">
                        <?php echo CHtml::submitButton('Delete Selected Class', array('id'=>'deletclassid','class' => 'btn btn-primary',"name"=>"deleteclass")); ?>
                    </div>
                </div>
            </div>
            </div>
            <?php }?>
            
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$ajaxClassUrl = Yii::app()->createUrl('/webpanel/payments/getclasses');
$ajaxClassPaymentUrl = Yii::app()->createUrl('/webpanel/payments/getclassesPayments');
$payment_type = $model->payment_type;
$js = <<< EOD
$(document).ready(function(){
    var payment_type  = '{$payment_type}';  
   
    if(payment_type=="CQ")
        $("#chequenumber").show();
    else if(payment_type=="MO")
        $("#moneyordernumber").show();
        
    $("#Payment_payment_type").on('change',function(){
        var id=$(this).val();
        
        $("#chequenumber").hide();
        $("#moneyordernumber").hide();
        
        if(id=="CQ")
        {
            $("#chequenumber").show();
        }else if(id=="MO")
        {
            $("#moneyordernumber").show();
        }
    }); 
    
    $("#searchclass").on('click',function(){
        var affcode=$("#Payment_affcode").val();
        $("#err_affcode").hide();
    
        if(affcode=="")
        {
           $("#err_affcode").show();
           return false;
        }  
    
       return true;     
    });  
    
    $("#deletclassid").on('click',function(){
        var classid=$("#Payment_class_id_payments").val();
        $("#err_class_id_payments").hide();
    
        if(classid=="")
        {
           $("#err_class_id_payments").show();
           return false;
        }  
    
       return true;     
    });  
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_payment', $js);
?>