<?php
/* @var $this PaymentsController */
/* @var $model Payment */
/* @var $form CActiveForm */
$this->title='Delete Class';
$this->breadcrumbs=array(
	'Payments'=>array('index'),
	$this->title,
);

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
                        'action' => array('/webpanel/payments/deleteclass/'),
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
                    
                    <div class="col-lg-2 col-md-2">
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
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<?php
$js = <<< EOD
$(document).ready(function(){
        
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