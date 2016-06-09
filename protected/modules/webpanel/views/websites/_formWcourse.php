<tr class="ncourse prcourse" id="clist-<?php echo $cid; ?>" data-cid="<?php echo $cid; ?>">   
    <?php
    if($model->isNewRecord) 
    { ?>                                          
        <td><?php echo $wcmodel->ctitle; ?> 
           ( <a href="#" class="child_popup" data-toggle='modal' data-target='#courses-modal' data-cid="<?php echo $cid; ?>">Child Courses</a> )
        </td>     
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cregisterurl]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cregisterurl_".$cid));?>            
        </td>
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cregisterurl_es]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cregisterurl_es_".$cid));?>            
        </td>
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cprice]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cprice_".$cid));?>            
        </td>
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cdiscount]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cdiscount_".$cid));?>            
        </td>  
        <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$cid}][sorder]",array('class'=>'form-control',"value"=>"0"));?></td>
    <?php 
    }else{
    ?>     
       <td> <?php echo $title; ?>
        ( <a href="#" class="child_popup" data-toggle='modal' data-target='#courses-modal' data-cid="<?php echo $cid; ?>">Child Courses</a> )
       </td>      
        <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cregisterurl]",array('class'=>'form-control',"value"=>$cregisterurl));?> </td>
        <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cregisterurl_es]",array('class'=>'form-control',"value"=>$cregisterurl_es));?> </td>
       <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cprice]",array('class'=>'form-control',"value"=>$cprice));?></td>
       <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$cid}][cdiscount]",array('class'=>'form-control',"value"=>$cdiscount));?></td>      
       <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$cid}][sorder]",array('class'=>'form-control',"value"=>$sorder));?>
   <?php 
    }?>
</tr>