<?php
/* @var $this WebsitesController */
/* @var $model Websites */
/* @var $form CActiveForm */
?>
<style>
    .crse_container { border:1px solid #ccc; height: 120px; overflow-y: scroll; }    
</style>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'websites-form',
                'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => true,
            ));
            ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'domainname', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-5">
                    <?php echo $form->textField($model, 'domainname', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'domainname'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-5">
                    <?php echo $form->textField($model, 'phone', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'image', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-2">
                <?php echo $form->fileField($model, 'image'); ?>    
                <?php echo $form->error($model, 'image'); ?>
                    </div> 
                     <div class="col-sm-2"><strong>(360x70)</strong></div>
                </div>                
                <?php
                if ($model->logo != "" && !$model->isNewRecord) {
                    ?>
                    <div class="form-group">    
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-5">
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/websites/' . $model->logo, $model->domainname, array('width' => 100, 'height' => 100)); ?>   
                        </div>
                    </div>
                <?php } ?>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'crs_image', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-2">
                <?php echo $form->fileField($model, 'crs_image'); ?>    
                <?php echo $form->error($model, 'crs_image'); ?>
                    </div>   
                    <div class="col-sm-2"><strong>(1175x320)</strong></div>
                </div>
                <?php
                if ($model->course_img != "" && !$model->isNewRecord) {
                    ?>
                    <div class="form-group">    
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-5">
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/homecourse/' . $model->course_img, $model->domainname, array('width' => 400, 'height' => 100)); ?>   
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'loginurl_en', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-5">
                    <?php echo $form->textField($model, 'loginurl_en', array('class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                    <?php echo $form->error($model, 'loginurl_en'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'loginurl_es', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-5">
                    <?php echo $form->textField($model, 'loginurl_es', array('class' => 'form-control', 'size' => 60, 'maxlength' => 250)); ?>
                    <?php echo $form->error($model, 'loginurl_es'); ?>
                    </div>
                </div>
                   
                
                <?php
                $clist = CHtml::listData(Courses::model()->findAll(), 'cid', 'ctitle_en');
                $wcmodel->clist = $selected_keys;
                ?>
                <div class="form-group">
                        <?php echo $form->labelEx($wcmodel, 'clist', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-8 crse_container">
                        <?php echo $form->checkBoxList($wcmodel, 'clist', $clist); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                                <table class="table table-bordered table-condensed" id="website_course">
                                    <tbody>
                                        <tr>
                                            <th style="width: 35%">Course Title</th>
                                            <th style="width: 20%">English register Url</th>
                                            <th style="width: 20%">Espanol register Url</th>
                                            <th style="width: 10%">Price</th>  
                                            <th style="width: 10%">Discount</th>                                              
                                            <th style="width: 5%">Order</th>                                              
                                        </tr>   
                                        <?php
                                        if (!$model->isNewRecord) {
                                            $new_wccourses = new WebsiteCourses();
                                            foreach ($list_wcmodel as $cwlist) {
                                                
                                                $decode_childs = array();
                                                $childcats = $cwlist->child;
                                                if($childcats!="")
                                                {
                                                    $decode_childs = json_decode($childcats,true);                                                    
                                                }  
                                                
                                                $parentid = $cwlist->cid;
                                                
                                                // Display parent courses
                                                $this->renderPartial('/websites/_formWcourse', array(
                                                    'model' => $model,
                                                    'wcmodel' => $wcmodel,
                                                    'cid'    => $cwlist->cid,
                                                    'title'  => $cwlist->c->ctitle_en,
                                                    'sorder' => $cwlist->sorder,
                                                    'cregisterurl' => $cwlist->cregisterurl,
                                                    'cregisterurl_es' => $cwlist->cregisterurl_es,
                                                    'cprice'    => $cwlist->cprice,
                                                    'cdiscount' => $cwlist->cdiscount,
                                                ));
                                                
                                                // Display child courses
                                                if(!empty($decode_childs))
                                                {  
                                                    
                                                    $decode_childs = Websites::model()->getchild_courses($decode_childs);
                                                   
                                                    foreach ($decode_childs as $chlist) {
                                                         $this->renderPartial('/websites/_formPop_course', array(
                                                            'model'     => $model,
                                                            'wcmodel'   => $wcmodel,
                                                            'cid'       => $chlist['cid'],
                                                            'parent_id' => $parentid,
                                                            'title'     => $chlist['ctitle'],
                                                            'sorder'    => $chlist['sorder'],
                                                            'cregisterurl' => $chlist['cregisterurl'],
                                                            'cregisterurl_es' => isset($chlist['cregisterurl_es'])?$chlist['cregisterurl_es']: '',
                                                            'cprice'    => $chlist['cprice'],
                                                            'cdiscount' => $chlist['cdiscount'],
                                                        ));
                                                    }
                                                }    
                                                
                                            }
                                        }
                                        ?>
                                    </tbody></table>
                    </div>
                </div>       
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'aboutus', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-6">
                        <?php echo $form->textArea($model, 'aboutus', array("id" => "aboutus", 'class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'aboutus'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'abt_image', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-2">
                <?php echo $form->fileField($model, 'abt_image'); ?>    
                <?php echo $form->error($model, 'abt_image'); ?>
                    </div>  
                     <div class="col-sm-2"><strong>(1175x320)</strong></div>
                </div>
                <?php
                if ($model->aboutus_img != "" && !$model->isNewRecord) {
                    ?>
                    <div class="form-group">    
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-5">
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/aboutus/' . $model->aboutus_img, $model->domainname, array('width' => 400, 'height' => 100)); ?>   
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'contactus', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-6">
                        <?php echo $form->textArea($model, 'contactus', array("id" => "contactus", 'class' => 'form-control', 'rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'contactus'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'cnt_image', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-2">
                <?php echo $form->fileField($model, 'cnt_image'); ?>    
                <?php echo $form->error($model, 'cnt_image'); ?>
                    </div>
                     <div class="col-sm-2"><strong>(1175x320)</strong></div>
                </div>
                <?php
                if ($model->contactus_img != "" && !$model->isNewRecord) {
                    ?>
                    <div class="form-group">    
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-5">
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/uploads/contactus/' . $model->contactus_img, $model->domainname, array('width' => 400, 'height' => 100)); ?>   
                        </div>
                    </div>
                <?php } ?>
                
                 <div class="form-group">
                    <?php echo $form->labelEx($model, 'copyright', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-5">
                    <?php echo $form->textField($model, 'copyright', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'copyright'); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo $form->checkBox($model, 'status'); ?>                        
                    </div>
                </div>
                <?php
                if (!$model->isNewRecord) {
                    ?>                     
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'created_at', array('class' => 'col-sm-3 control-label')); ?>
                        <div class="col-sm-5">
                            <?php echo $model->created_at; ?>
                        </div>
                    </div> 
                    <?php if ($model->modified_at != "0000-00-00 00:00:00") { ?>
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'modified_at', array('class' => 'col-sm-3 control-label')); ?>
                            <div class="col-sm-5">
                                <?php echo $model->modified_at; ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php }
                ?>  
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-0 col-sm-offset-3">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div><!-- ./col -->
</div>
<div class="modal modal-wide fade" id="courses-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-folder-open-o"></i>Select Courses</h4>
                <div id="courses_contents"></div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js">
    <?php
    $ajax_getcourses = Yii::app()->createUrl('/webpanel/websites/getcourses');
    $callback = Yii::app()->createUrl('/webpanel/websites/ajaxcreate');
    $js = <<<JS
    $(function() {
        
        $(".modal-wide").on("show.bs.modal", function() {
            var height = $(window).height() - 200;
            $(this).find(".modal-body").css("max-height", height);
        });
      
        $('.child_popup').live('click',function(event){
            event.preventDefault();
            var c_id = $(this).data("cid");   
            var childcids=[];
            $('.ncourse').each(function() {
                var tr_cid = $(this).data('cid');
                var tr_pcid = $(this).data('parent-cid');            
                if(c_id==tr_pcid)
                { 
                    childcids.push(tr_cid);
                }             
            });

            $.ajax({
                url: '{$ajax_getcourses}',
                type: "POST",   
                data:'cid='+c_id+'&childcids='+childcids,
                success: function(data){                                 
                    $("#courses_contents").html(data);               
                }
             });
        });     
        
        $(".popupcourse").live("click", function(){ // on change of state
                
            var cid = parseInt($(this).val(), 10);
            var parent_courseid = $("#parent_courseid").val();                
                
            if($(this).is(":checked")) {

                // Get the course title          
                var ctitle = $('label[for="' + $(this).attr("id") + '"]').html();

                $.ajax({
                    url  : "{$callback}",
                    type : "POST",
                    dataType : "json",
                    data: {
                      id: cid,
                      label: ctitle,
                      type:'ajax',  
                      pid:parent_courseid  
                    },
                    success: function(data) {
                     // $("#popup_website_course tbody").append(data.html);
                        $("#clist-"+parent_courseid).after(data.html);
                    }
                }); 

            } else {

                $("#clist-parent-"+parent_courseid+"-child-"+cid).find("td").fadeOut(1000,function()
                {
                    $(this).parent().remove();
                });
            }
         })   
                
        $('input').on('ifChecked', function(event){
            
            var cid = $(this).val();            
            // Get the course title          
            var ctitle = $('label[for="' + $(this).attr("id") + '"]').html();
          
            $.ajax({
                url  : "{$callback}",
                type : "POST",
                dataType : "json",
                data: {
                  id: cid,
                  label: ctitle,
                  type:'normal'  
                },
                success: function(data) {
                  $("#website_course tbody").append(data.html);
                }
            });          
        });
        
        $('input').on('ifUnchecked', function(event){
            var cid = $(this).val();           
            $("#clist-"+cid).find("td").fadeOut(1000,function()
                {
                    $(this).parent().remove();
                });
            return false;
        });
                
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('aboutus');
        CKEDITOR.replace('contactus');
   
});
JS;

    Yii::app()->clientScript->registerCoreScript('jquery');
    Yii::app()->clientScript->registerScript('WebsiteForm', $js, CClientScript::POS_END);
    ?>