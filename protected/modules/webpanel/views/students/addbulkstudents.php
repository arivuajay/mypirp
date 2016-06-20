<?php
/* @var $this MasterCurrencyRatesController */
/* @var $dataProvider CActiveDataProvider */

$this->title = 'Add Students';
$this->breadcrumbs = array(
    'Add Students',
);
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs_pos_end = CClientScript::POS_END;
$cs->registerCssFile($themeUrl . '/css/datepicker/datepicker3.css');
$cs->registerScriptFile($themeUrl . '/js/datepicker/bootstrap-datepicker.js', $cs_pos_end);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'post-document-form',
    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
        ));
?>
<div class="col-lg-12 col-md-12">
    <div class="row">
        <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success pull-right')); ?>
    </div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="col-lg-12 col-md-12">
    <div class="table-responsive">
    <table class="table table-striped table-bordered bulkstudentsadd" >
        <thead>
            <tr>
                <td align="center"><strong>No</strong></td>
                <td align="center"><strong>First name</strong></td>
                <td align="center"><strong>Middle name</strong></td>
                <td align="center"><strong>Last name</strong></td>     
                <td align="center"><strong>Suffix</strong></td>
                <td align="center"><strong>Address 1</strong></td>
                <td align="center"><strong>Address 2</strong></td>
                <td align="center"><strong>City</strong></td>
                <td align="center"><strong>State</strong></td>
                <td align="center"><strong>Zipcde</strong></td>
                <td align="center"><strong>Phone</strong></td>
                <td align="center"><strong>Email</strong></td>
                <td align="center"><strong> Gender</strong></td>
                <td align="center"><strong> DOB</strong></td>
                <td align="center"><strong> Lice. Num:</strong></td>
                <td align="center"><strong> Cource Completion Dt</strong></td>
            </tr>                
        </thead>
        <?php
        $no_of_st = 20;
        for ($i = 1; $i <= $no_of_st; $i++) {
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $form->textField($model,  '['.$i.']'. 'first_name', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'middle_name', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'last_name', array('class' => 'form-control', 'size' => 25)); ?></td>                    
                <td><?php echo $form->textField($model, '['.$i.']'.'stud_suffix', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'address1', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'address2', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'city', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'state', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'zip', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'phone', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->textField($model, '['.$i.']'.'email', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td><?php echo $form->dropDownList($model, '['.$i.']'.'gender', array(""=>"Select One","F" => "Female", "M" => "Male"), array('class' => 'form-control')); ?></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
                        <?php echo $form->textField($model, '['.$i.']'.'dob', array('class' => 'form-control date', 'size' => 25)); ?>
                    </div> 
                </td>
                <td><?php echo $form->textField($model, '['.$i.']'.'licence_number', array('class' => 'form-control', 'size' => 25)); ?></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
                        <?php echo $form->textField($model, '['.$i.']'.'course_completion_date', array('class' => 'form-control date', 'size' => 25)); ?>
                    </div> 
                </td>
            </tr>
            <?php
        }
        ?>       
    </table>  
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.year').datepicker({dateFormat: 'yyyy'});
        $('.date').datepicker({format: 'yyyy-mm-dd'});
    });
</script>