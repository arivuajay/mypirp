<?php
/* @var $this PaymentsController */
/* @var $model Payment */
/* @var $form CActiveForm */
$cardtypes = Myclass::card_types();
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
            'id' => 'payment-form',
            'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
            'clientOptions' => array(
            'validateOnSubmit' => true,
            ),
            'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <?php if ($model->isNewRecord) { ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'affiliatesid', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5"> 
                        <?php echo $form->dropDownList($model, 'affiliatesid', $affiliates, array('class' => 'form-control', "empty" => "Select Agency")); ?>
                        <?php echo $form->error($model, 'affiliatesid'); ?>
                    </div>
                </div>
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
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">                       
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-calendar"></i></span>
                            <?php echo $form->textField($model, 'payment_date', array('class' => 'form-control date',"readonly"=>"readonly")); ?>
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
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$ajaxClassUrl = Yii::app()->createUrl('/webpanel/payments/getclasses');
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
        
    $("#Payment_affiliatesid").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;

        $.ajax({
            type: "POST",
            url: '{$ajaxClassUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#Payment_class_id").html(html);
            }
         });
   });
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_payment', $js);
?>