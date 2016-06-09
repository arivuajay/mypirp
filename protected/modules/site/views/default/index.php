<div class="body-cont">
  <div class="container">
    
    <div class="slider-cont">
        <div class="slider-txt"> Courses</div>
        <img src="/uploads/homecourse/<?php echo $course_img;?>"  alt="Courses">
    </div>
      
    <div class="course-cont">      
        
        <div class="row">
        <?php
        if(!empty($courses_list))
        {  
            $k=1;
            $count = count($courses_list);
            $flag = $count % 2;
            foreach($courses_list as $cinfo)
            {    
                $dlist    = array();
                $cid      = $cinfo->cid;
                $discount = $cinfo->cdiscount;
                $discount_disp = ($discount!="")?"<br/>Save ".$discount:""; 
                
                $ctitle        = "ctitle_".$sitelang;
                $cshortdesc    = "cshortdesc_".$sitelang;
                $cdescription  = "cdescription_".$sitelang;
                $cdescription_list = "cdescription_list_".$sitelang;
                $dlist = json_decode($cinfo->c->{$cdescription_list});
        ?>    
            <?php if($k==$count && $flag == 1){ ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3  col-lg-offset-3">
            <?php }else{?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">    
            <?php }?>
                <div class="single-course-cont">
                  <div class="course-heading">
                    <div class="course-price">
                      <div class="course-txt">
                        <p> <?php echo $cinfo->cprice;?></p>
                        <span> ON SALE <?php echo $discount_disp;?></span> </div>
                    </div>
                      
                    <div class="course-heading2">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" valign="middle"><?php echo $cinfo->c->{$ctitle};?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  
                  <div class="course-heading3">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle"><?php echo $cinfo->c->{$cshortdesc};?></td>
                      </tr>
                    </table>
                  </div>                  
                                      
                  <div class="course-heading4">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle"><?php echo $cinfo->c->{$cdescription};?></td>
                      </tr>
                    </table>
                  </div>                  
                    
                  <?php if(!empty($dlist)){?>    
                  <div class="course-features">
                    <ul>
                      <?php  
                        foreach($dlist as $dinfo)  
                        {  ?>
                         <li><?php echo $dinfo;?></li>
                        <?php
                        }
                      ?>
                    </ul>
                  </div>
                  <?php } ?>  
                    
                  <?php                     
                   if(isset($cinfo->child) && !empty($cinfo->child) && $cinfo->child!="null")
                   {
                       $regisurl = Yii::app()->createUrl("/site/default/innercourses",array("cid"=>$cid));
                   }else{
                       $regisurl = ($sitelang == 'es' )?$cinfo->cregisterurl_es:$cinfo->cregisterurl;
                   }     
                  ?>
                  <div class="register-cont"> <a href="<?php echo $regisurl; ?>" class="btn btn-default"> Register</a> </div>
                  
                </div>
              </div> 
             <?php 
            if($k%2==0){?>
                <div class="clearfix"></div>  
            <?php }?> 
        <?php
         $k++;
            }
        }else{
            ?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-md-6">
                <p>Courses are not available.</p>
            </div>
        <?php        
        }?>
        </div>
        <?php $this->renderPartial('_certificateshipping', array('themeurl' => $themeurl)); ?>
    </div>
  </div>
</div>
