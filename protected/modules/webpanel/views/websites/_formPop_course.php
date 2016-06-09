<tr class="ncourse chcourse" data-parent-cid="<?php echo $parent_id; ?>" data-cid="<?php echo $cid; ?>" id="clist-parent-<?php echo $parent_id; ?>-child-<?php echo $cid; ?>">   
    <?php
    if($model->isNewRecord) 
    { ?>                                          
        <td><?php echo $wcmodel->ctitle; ?></td>     
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cregisterurl]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cregisterurl_".$cid));?>           
        </td>
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cregisterurl_es]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cregisterurl_es_".$cid));?>           
        </td>
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cprice]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cprice_".$cid));?>           
        </td>
        <td>
            <?php echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cdiscount]",array('class'=>'form-control',"value"=>"","id"=>"WebsiteCourses_cdiscount_".$cid));?>            
        </td>  
        <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][sorder]",array('class'=>'form-control',"value"=>"0"));?></td>
    <?php 
    }else{
    ?>     
       <td> <?php echo $title; ?></td>      
        <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cregisterurl]",array('class'=>'form-control',"value"=>$cregisterurl));?></td>
        <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cregisterurl_es]",array('class'=>'form-control',"value"=>$cregisterurl_es));?></td>
       <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cprice]",array('class'=>'form-control',"value"=>$cprice));?></td>
       <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][cdiscount]",array('class'=>'form-control',"value"=>$cdiscount));?></td>      
       <td><?php  echo CHtml::activeTextField($wcmodel,"courses[{$parent_id}][child][{$cid}][sorder]",array('class'=>'form-control',"value"=>($sorder!="" || !empty($sorder))?$sorder:"0"));?>
   <?php 
    }?>
</tr>