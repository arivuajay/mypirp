<?php
$selected_Array = array();
$selected_Array = explode(",",$ch_cids);
$clist = CHtml::listData(Courses::model()->findAll("cid!=".$cid), 'cid', 'ctitle_en');
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
            <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'course-append-form',
                    'htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'),
                ));
            ?>
            <div class="box-body">                
                <div class="form-group">                   
                    <div class="col-sm-12 crse_container">
                    <?php echo CHtml::CheckBoxList('courselist',$selected_Array,$clist,array("class"=>"popupcourse"));  ?>
                    </div>
                     <input type="hidden" name="parentid" id="parent_courseid" value="<?php echo $cid;?>">
                </div>  
            </div><!-- /.box-body -->
          <?php $this->endWidget(); ?>
        </div><!-- /.box -->
    </div>
</div>