<div class="body-cont">
    <div class="container">
        <div class="slider-cont">
            <div class="slider-txt"> Courses</div>
             <img src="/uploads/homecourse/<?php echo $course_img;?>"  alt="Courses">
              <div class="course-cont">
                  <div class="row">
                    <?php
                    if(!empty($course_data))
                    {    
                        $k=1;
                        
                        foreach($course_data as $cinfo)
                        {    

                           $discount = $cinfo['cdiscount'];
                           $discount_disp = ($discount!="")?"<br/>Save ".$discount:""; 

                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-md-4">
                          <div class="single-course-cont single-course-cont2">
                            <div class="course-heading">
                              <div class="course-price">
                                <div class="course-txt">
                                  <p> <?php echo $cinfo['cprice'];?></p>
                                  <span> ON SALE <?php echo $discount_disp;?></span> </div>
                              </div>
                              <div class="course-heading2">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="center" valign="middle"><?php echo $cinfo['ctitle'];?></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <div class="course-heading3">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="center" valign="middle"><?php echo $cinfo['cshortdesc'];?></td>
                                </tr>
                              </table>
                            </div>
                            <div class="course-heading4">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="center" valign="middle"><?php echo $cinfo['cdescription'];?></td>
                                </tr>
                              </table>
                            </div>
                             <?php if($cinfo['cdescription_list'] != ""){?>      
                            <div class="course-features">
                              <ul>
                                <?php  
                                foreach($cinfo['cdescription_list'] as $dinfo)  
                                {  ?>
                                 <li><?php echo $dinfo;?></li>
                                <?php
                                }
                                ?>
                              </ul>
                            </div>
                            <?php } ?>    
                              <?php $regisurl = ($sitelang == 'es' )?$cinfo['cregisterurl_es']:$cinfo['cregisterurl']; ?>
                              <div class="register-cont"> <a href="<?php echo $regisurl;?>" class="btn btn-default"> Register</a> </div>
                          </div>
                        </div>
                       <?php 
                       if($k%3==0){?>
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
</div>    