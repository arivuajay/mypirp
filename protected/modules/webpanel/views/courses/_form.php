<?php
/* @var $this CoursesController */
/* @var $model Courses */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'courses-form',
                   // 'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal','enctype'=>'multipart/form-data'),
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                    'enableAjaxValidation'=>true,
            )); ?>
            <div class="box-body">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <div class="box-header">
                            <h3 class="box-title">Course ( English )</h3>
                        </div>
                    </div>
                     <div class="col-sm-6">
                        <div class="box-header">
                            <h3 class="box-title">Course ( Español )</h3>
                        </div>
                    </div>
                </div>    
                   <div class="form-group">
                        <?php echo $form->labelEx($model,'ctitle_en',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textField($model,'ctitle_en',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'ctitle_en'); ?>
                        </div>
                       
                       <?php echo $form->labelEx($model,'ctitle_es',  array('class' => 'col-sm-1 control-label')); ?>
                       <div class="col-sm-5">
                        <?php echo $form->textField($model,'ctitle_es',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
                        <?php echo $form->error($model,'ctitle_es'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'cshortdesc_en',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textArea($model,'cshortdesc_en',array('class'=>'form-control','rows'=>6, 'cols'=>5)); ?>
                        <?php echo $form->error($model,'cshortdesc_en'); ?>
                        </div>
                        
                        <?php echo $form->labelEx($model,'cshortdesc_es',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textArea($model,'cshortdesc_es',array('class'=>'form-control','rows'=>6, 'cols'=>5)); ?>
                        <?php echo $form->error($model,'cshortdesc_es'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'cdescription_en',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textArea($model,'cdescription_en',array('class'=>'form-control','rows'=>6, 'cols'=>10)); ?>
                        <?php echo $form->error($model,'cdescription_en'); ?>
                        </div>
                        
                        <?php echo $form->labelEx($model,'cdescription_es',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->textArea($model,'cdescription_es',array('class'=>'form-control','rows'=>6, 'cols'=>10)); ?>
                        <?php echo $form->error($model,'cdescription_es'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'cdescription_list_en',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                            <div class="row">
                                <table id="course-list_en" >      
                                    <tbody>
                                        <?php                                       
                                        $newChoiceCount_en = 0;
                                        foreach ($choices_en as $choice) 
                                        {
                                            $this->renderPartial('/courses/_formChoice', array(
                                                'model'  => $model,
                                                'chce_id'=> 'new'. ++$newChoiceCount_en,
                                                'choice' => $choice, 
                                                'lang'   => 'en'
                                            ));
                                        }
                                        ++$newChoiceCount_en; // Increase once more for Ajax additions
                                        ?>
                                        <tr id="add-coursedec-row_en">                              
                                            <td class="labeltxt_en col-sm-5" style="padding-top: .5em; padding-bottom: .5em;">
                                                <?php echo $form->textField($model,'add_choice_en', array('class' => 'form-control', 'size' => 60, 'id' => 'add_choice_en')); ?>
                                                <div class="errorMessage" id="labelerror_en" style="display:none;">You must enter a point.</div>  
                                                <?php //echo $form->error($model, 'labelerror'); ?>
                                            </td>                      
                                        </tr>
                                        <tr>                           
                                            <td class="labeltxt_en col-sm-5">
                                                <a href="#" id="add-coursedec_en"><i class="glyphicon glyphicon-plus-sign"></i> Add description point</a>
                                            </td>       
                                        </tr>
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                        
                        <?php echo $form->labelEx($model,'cdescription_list_es',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                            <div class="row">
                                <table id="course-list_es" >      
                                    <tbody>
                                        <?php                                       
                                        $newChoiceCount_es = 0;
                                        foreach ($choices_es as $choice_es) 
                                        {
                                            $this->renderPartial('/courses/_formChoice', array(
                                                'model'  => $model,
                                                'chce_id'=> 'new'. ++$newChoiceCount_es,
                                                'choice' => $choice_es,  
                                                'lang'   => 'es'
                                            ));
                                        }
                                        ++$newChoiceCount_es; // Increase once more for Ajax additions
                                        ?>
                                        <tr id="add-coursedec-row_es">                              
                                            <td class="labeltxt_es col-sm-5" style="padding-top: .5em; padding-bottom: .5em;">
                                                <?php echo $form->textField($model,'add_choice_es', array('class' => 'form-control', 'size' => 60, 'id' => 'add_choice_es')); ?>
                                                <div class="errorMessage" id="labelerror_es" style="display:none;">You must enter a point.</div>  
                                                <?php echo $form->error($model, 'labelerror'); ?>
                                            </td>                      
                                        </tr>
                                        <tr>                           
                                            <td class="labeltxt col-sm-5">
                                                <a href="#" id="add-coursedec_es"><i class="glyphicon glyphicon-plus-sign"></i> Add description point</a>
                                            </td>       
                                        </tr>
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                        
                    </div>
                
<!--                    <div class="form-group">
                        <?php ///echo $form->labelEx($model,'image',  array('class' => 'col-sm-2 control-label')); ?>
                        <div class="col-sm-5">
                        <?php //echo $form->fileField($model, 'image');?>    
                        <?php //echo $form->error($model,'image'); ?>
                        </div>
                    </div>-->
                    <?php
                    //  if($model->cimage!="" && !$model->isNewRecord)                            
                     //  {  ?>
<!--                        <div class="form-group">    
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-5">
                        <?php // echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/courses/'.$model->cimage,$model->ctitle,array('width'=>100,'height'=>100));             ?>   
                            </div>
                        </div>-->
                  <?php// } ?>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'status',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->checkBox($model,'status');?>                        
                        </div>
                        
                         <?php echo $form->labelEx($model,'status_es',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $form->checkBox($model,'status_es');?>                        
                        </div>
                    </div>

                   <?php
                    if(!$model->isNewRecord)
                    {?>                     
                    <div class="form-group">
                        <?php echo $form->labelEx($model,'created_at',  array('class' => 'col-sm-1 control-label')); ?>
                        <div class="col-sm-5">
                        <?php echo $model->created_at; ?>
                        </div>
                    </div> 
                    <?php if($model->modified_at!="0000-00-00 00:00:00"){ ?>
                    <div class="form-group">
                         <?php echo $form->labelEx($model,'modified_at',  array('class' => 'col-sm-1 control-label')); ?>
                         <div class="col-sm-5">
                         <?php echo $model->modified_at; ?>
                         </div>
                    </div>
                    <?php }?>
                    <?php
                    }?>

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
$callback = Yii::app()->createUrl('/webpanel/courses/ajaxcreate');
$js = <<<JS
// For english          
var CourseList_en = function(o) {   
    this.target = o;
        
    this.labeltxt_en     = jQuery(".labeltxt_en input", o);   
    this.errorMessage_en = jQuery("#labelerror_en", o);
    var pc_en = this;
    pc_en.labeltxt_en.blur(function() {
      pc_en.validate();
    });  
        
  }
        
CourseList_en.prototype.validate = function() {
    var valid = true;
    if (this.labeltxt_en.val() == "") {
      valid = false;
      this.errorMessage_en.fadeIn();
    }
    else {
      this.errorMessage_en.fadeOut();
    }
    return valid;
  }
        
var newChoiceCount_en = {$newChoiceCount_en};
var addCourseList_en = new CourseList_en(jQuery("#add-coursedec-row_en"));
 
jQuery("tr", "#course-list_en tbody").each(function() {
  new CourseList_en(jQuery(this));
});  

jQuery("#add-coursedec_en").click(function() {

  if (addCourseList_en.validate()) {
    jQuery.ajax({
      url: "{$callback}",
      type: "POST",
      dataType: "json",
      data: {
        id: "new"+ newChoiceCount_en,
        lang : "en",
        label: addCourseList_en.labeltxt_en.val()
      },
      success: function(data) {
        addCourseList_en.target.before(data.html);
        addCourseList_en.labeltxt_en.val('');
        new CourseList_en(jQuery('#'+ data.id));
      }
    });

    newChoiceCount_en += 1;
  }

  return false;
});

// For spanish   
var CourseList_es = function(o) {    
    this.target = o;
        
    this.labeltxt_es     = jQuery(".labeltxt_es input", o);   
    this.errorMessage_es = jQuery("#labelerror_es", o);
    var pc_es = this;
    pc_es.labeltxt_es.blur(function() {
      pc_es.validate();
    }); 
}    
    
CourseList_es.prototype.validate = function() {
    var valid = true;
    if (this.labeltxt_es.val() == "") {
      valid = false;
      this.errorMessage_es.fadeIn();
    }
    else {
      this.errorMessage_es.fadeOut();
    }
    return valid;
  }        

var newChoiceCount_es = {$newChoiceCount_es};
var addCourseList_es = new CourseList_es(jQuery("#add-coursedec-row_es"));

jQuery("tr", "#course-list_es tbody").each(function() {
  new CourseList_es(jQuery(this));
});

jQuery("#add-coursedec_es").click(function() {

  if (addCourseList_es.validate()) {
    jQuery.ajax({
      url: "{$callback}",
      type: "POST",
      dataType: "json",
      data: {
        id: "new"+ newChoiceCount_es,
        lang : "es",
        label: addCourseList_es.labeltxt_es.val()
      },
      success: function(data) {
        addCourseList_es.target.before(data.html);
        addCourseList_es.labeltxt_es.val('');
        new CourseList_es(jQuery('#'+ data.id));
      }
    });

    newChoiceCount_es += 1;
  }

  return false;
});
JS;

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('CourseHelp', $js, CClientScript::POS_END);
?>
