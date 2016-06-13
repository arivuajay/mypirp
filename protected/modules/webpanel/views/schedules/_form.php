<?php
/* @var $this SchedulesController */
/* @var $model DmvClasses */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'dmv-classes-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                  <?php echo $form->error($model, 'composite_error'); ?>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'affiliate_id', array('class' => 'col-sm-2 control-label')); ?>                   
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'affiliate_id', $affiliates, array('class' => 'form-control', "empty" => "Select One")); ?>         
                        <?php echo $form->error($model, 'affiliate_id'); ?>
                    </div>    
                </div>

                <div class="form-group">                            
                    <?php echo $form->labelEx($model, 'instructor_id', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->dropDownList($model, 'instructor_id', $instructors, array('class' => 'form-control', "empty" => "Select One")); ?>     
                        <?php echo $form->error($model, 'instructor_id'); ?>
                    </div>    
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'clas_date', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'clas_date', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'clas_date'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'start_time', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'start_time', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'start_time'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'end_time', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'end_time', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'end_time'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'date2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'date2', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'date2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'start_time2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'start_time2', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'start_time2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'end_time2', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'end_time2', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'end_time2'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'location', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'location', array('class' => 'form-control', 'size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($model, 'location'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'loc_addr', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'loc_addr', array('class' => 'form-control', 'size' => 30, 'maxlength' => 30)); ?>
                        <?php echo $form->error($model, 'loc_addr'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'loc_city', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'loc_city', array('class' => 'form-control', 'size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($model, 'loc_city'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'loc_state', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'loc_state', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'loc_state'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'zip', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'zip', array('class' => 'form-control', 'size' => 10, 'maxlength' => 10)); ?>
                        <?php echo $form->error($model, 'zip'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'country', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'country'); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model, 'show_admin', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'show_admin', array('class' => 'form-control', 'size' => 1, 'maxlength' => 1)); ?>
                        <?php echo $form->error($model, 'show_admin'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'pending', array('class' => 'col-sm-2 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->textField($model, 'pending', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model, 'pending'); ?>
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
?>
<script type="text/javascript">
    $(document).ready(function () {
        //$.fn.dataTableExt.sErrMode = 'throw';   
        $("#DmvClasses_affiliate_id").change(function () {
            var id = $(this).val();
            var dataString = 'id=' + id + '&form=schedules';

            $.ajax({
                type: "POST",
                url: '<?php echo $ajaxInstructorsUrl; ?>',
                data: dataString,
                cache: false,
                success: function (html) {
                    $("#DmvClasses_instructor_id").html(html);
                }
            });
        });
    });
</script>