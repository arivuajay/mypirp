<tr id="desclist-<?php echo $lang;?>-<?php echo $chce_id; ?>">
  <td class="labeltxt col-sm-12" style="padding-top: .5em; padding-bottom: .5em;">
    <?php
    if($lang=="en")
    {    
        if(!$model->isNewRecord)
        {   
          echo CHtml::activeTextField($model,"cdescription_list_en[]",array('class' => 'form-control','size'=>60,"value"=>$choice));  
        }else{
          echo CHtml::activeTextField($model,"cdescription_list_en[]",array('class' => 'form-control','size'=>60,"value"=>$model->cdescription_list_en));  
        }
    }else{
        if(!$model->isNewRecord)
        {   
          echo CHtml::activeTextField($model,"cdescription_list_es[]",array('class' => 'form-control','size'=>60,"value"=>$choice));  
        }else{
          echo CHtml::activeTextField($model,"cdescription_list_es[]",array('class' => 'form-control','size'=>60,"value"=>$model->cdescription_list_es));  
        }
    }    ?>
    <div class="errorMessage" style="display:none">Please enter description point.</div>
  </td>
  <td class="actions col-sm-2">
  <?php
    $deleteJs = 'jQuery("#desclist-'.$lang.'-'. $chce_id .'").find("td").fadeOut(1000,function(){jQuery(this).parent().remove();});return false;';
    echo CHtml::link('<i class="glyphicon glyphicon-trash"></i>', '#', array('onclick' => 'js:'. $deleteJs));    
  ?>
  </td>
</tr>
