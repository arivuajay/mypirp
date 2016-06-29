<?php
/* @var $this BookordersController */
/* @var $model BookOrders */
/* @var $form CActiveForm */
$cardtypes = Myclass::card_types();
unset($cardtypes["MO"]);
$instructors = array();
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'book-orders-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'affiliate_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php if ($model->isNewRecord) { ?>
                            <?php echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control', "empty" => "Select Affiliate")); ?>  
                            <?php echo $form->error($model, 'affiliate_id'); ?>
                            <?php
                        } else {
                            echo $model->affiliateInfo->agency_name;
                        }
                        ?>
                    </div>
                </div>

                <?php if ($model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'book_instructor', array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">                       
                            <?php
                            $chck = ($model->book_instructor == "Y") ? "checked" : "";
                            echo $form->checkBox($model, 'book_instructor', array('class' => 'form-control', 'checked' => $chck));
                            ?>
                            <?php echo $form->error($model, 'book_instructor'); ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group" style="display:none;" id="instructor_disp">
                    <?php echo $form->labelEx($model, 'instructor_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">  
                        <?php if ($model->isNewRecord) { ?>
                            <?php echo $form->dropDownList($model, 'instructor_id', $instructors, array('class' => 'form-control')); ?>    
                            <?php echo $form->error($model, 'instructor_id'); ?>
                            <?php
                        } else {
                            echo $model->instructorInfo->ins_first_name." ".$model->instructorInfo->instructor_last_name;
                        }
                        ?>
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
                    <?php echo $form->labelEx($model, 'number_of_books', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'number_of_books', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'number_of_books'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'book_fee', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-dollar"></i></span>
                            <?php echo $form->textField($model, 'book_fee', array('class' => 'form-control')); ?>
                        </div>  
                        <?php echo $form->error($model, 'book_fee'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'shipping_fee', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon">  <i class="fa fa-dollar"></i></span>
                            <?php echo $form->textField($model, 'shipping_fee', array('class' => 'form-control')); ?>
                        </div>   
                        <?php echo $form->error($model, 'shipping_fee'); ?>
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

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'payment_complete', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php
                        $chck = ($model->payment_complete == "Y") ? "checked" : "";
                        echo $form->checkBox($model, 'payment_complete', array('class' => 'form-control', 'checked' => $chck));
                        ?>
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
$ajaxInstructorsUrl = Yii::app()->createUrl('/webpanel/instructors/getinstructors');
$payment_type = $model->payment_type;
$book_instructor = $model->book_instructor;
$js = <<< EOD
$(document).ready(function(){
    var payment_type  = '{$payment_type}';
    var book_instructor = '{$book_instructor}';
    
    if(payment_type=="CQ")
      $("#chequenumber").show();
             
    $("#BookOrders_payment_type").on('change',function(){
        var id=$(this).val();        
        $("#chequenumber").hide();        
        if(id=="CQ")
        {
            $("#chequenumber").show();
        }
    }); 
    
    if(book_instructor=="Y")
    $('#instructor_disp').show(); 
   
    $('input[name="BookOrders\\[book_instructor\\]"]').on('ifChecked', function(event){      
        $('#instructor_disp').show();          
    });
    
    $('input[name="BookOrders\\[book_instructor\\]"]').on('ifUnchecked', function(event){      
        $('#instructor_disp').hide();          
    });
    
    $("#BookOrders_affiliate_id").change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id +'&form=bookorder';

        $.ajax({
            type: "POST",
            url: '{$ajaxInstructorsUrl}',
            data: dataString,
            cache: false,
            success: function(html){             
                $("#BookOrders_instructor_id").html(html);
            }
         });
   });
    
});
EOD;
Yii::app()->clientScript->registerScript('_form_bookorders', $js);
?>
