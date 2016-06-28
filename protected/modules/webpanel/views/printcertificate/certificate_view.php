<style>
.certificate-cont{
    background: none repeat scroll 0 0 #ffffff !important;
    color: #000000 !important;
    //font-family: Times New Roman;
    font-size: 12pt !important;
    margin-top: 10px;    
}

.certificate-cont .cert-table{
   // border: #000000 solid 1px;
   // border-bottom: #000000 solid 2px;
    line-height: 28px;
}

.certificate-cont h3{ 
 //font-family: Times New Roman;
 font-size: 18px;
 font-weight: bold;
  color: #000000 !important;
}

.certificate-cont td{
   color: #000000; 
   line-height: 22px;
}

.certificate-stud-cont{
 //font-family: Times New Roman;
  margin-top: 325px;
  font-size: 25px;
  color: #000000 !important;
  //text-transform: uppercase;
  border: none;
}

.certificate-stud-cont td{
    color: #000000 !important;
    font-size: 18px !important;
}    
</style>
<?php
$themeUrl = $this->themeUrl;
//$cs = Yii::app()->getClientScript();
//$cs->registerCssFile($themeUrl . '/css/custom.css');

if (!empty($std_ids)) {

    $sresults_info = Students::model()->with("dmvAffiliateInfo")->findAll("student_id in ($std_ids)");

    if (!empty($sresults_info)) {
        foreach ($sresults_info as $sinfo) {
            $std_liveplace = array();
            $std_place = "";
            $agency_code = $sinfo->dmvAffiliateInfo->agency_code;
            $agency_name = $sinfo->dmvAffiliateInfo->agency_name;
            $class_id = $sinfo->clas_id;
            $student_id = $sinfo->student_id;
            $certificate_no = PrintCertificate::model()->find("class_id=" . $class_id . " and student_id=" . $student_id)->certificate_number;
            // Student Info
            $first_name = $sinfo->first_name;
            $middle_name = $sinfo->middle_name;
            $last_name = $sinfo->last_name;
            $address1 = $sinfo->address1;
            $address2 = $sinfo->address2;
            $std_address = trim($sinfo->address1 . " " . $sinfo->address2);
            $city = $sinfo->city;
            $state = $sinfo->state;
            $zip = $sinfo->zip;
            $std_liveplace[] = $city;
            $std_liveplace[] = $state;
            if (!empty($std_liveplace)) {
                $std_place = array_filter($std_liveplace);
                $std_place = implode(" ,", $std_place);
                $std_place = trim($std_place);
            }

            $dob = ($sinfo->dob != "0000-00-00") ? date("m/d/Y", strtotime($sinfo->dob)) : "-";
            $gender = ($sinfo->gender == "F") ? "Female" : "Male";
            $licence_number = $sinfo->licence_number;
            $clas_date = ($sinfo->course_completion_date != "0000-00-00") ? date("m/d/Y", strtotime($sinfo->course_completion_date)) : "-";
            ?>
            <div class="certificate-cont">
                <table width="100" border="0" cellpadding="0" cellspacing="0" class="cert-table">
                    <tr>
                        <td><table width="900px" height="400" border="1" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table style="width:100%" border="0"  cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:60%;text-align:left;"><h3><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFICATE OF COMPLETION</i></h3></td>
                                                        <td style="width:40%;text-align:right;"><h3>NO:&nbsp;&nbsp;#028-0<?php echo $certificate_no; ?>&nbsp;&nbsp;&nbsp;</h3></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:60%"><h3><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AMERICAN SAFETY INC.</i></h3></td>
                                                        <td style="width:40%">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:60%">&nbsp;</td>
                                                        <td style="width:40%;text-align:right;"><b>Delivery Agency Code: <?php echo $agency_code; ?>&nbsp;&nbsp;&nbsp;</b> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="align:center; width:100%" border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="align:left; width:100%;text-align: left;"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This certifies that the person named below has successfully completed American Safety Inc.'s 6-hour Point &amp; Insurance
                                                                Reduction Program. In compliance with Section 2336 of the New York State Insurance Law.&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="align:left; width:100%">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="align:left; text-align: left; width:100%;">
                                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>American Safety Inc.</b><br />
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>111 Washington Ave., Ste 606</b><br />
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Albany, NY 12210</b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                        <td>&nbsp;</td>                                                       
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 100% ">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 60% ">
                                                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100% ">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student DL#:&nbsp;&nbsp;<?php echo $licence_number; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student Name:&nbsp;<?php echo $first_name; ?>&nbsp;<?php echo $last_name; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date
                                                                            of Birth:&nbsp;&nbsp;<?php echo $dob; ?>&nbsp;&nbsp;&nbsp;Sex: &nbsp;<?php echo $gender; ?> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Course Completion Date:&nbsp;<?php echo $clas_date; ?> </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>    
                                                        <td style="width: 40% ">
                                                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; text-align:right;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" nowrap="nowrap">&nbsp;</td>
                                                                        <td style="align:left; text-align: left;" nowrap="nowrap"><b><?php echo $agency_name; ?></b></td>
                                                                        <td align="center" valign="top" nowrap="nowrap">&nbsp;</td>
                                                                    </tr>                                                                   
                                                                    <tr>
                                                                        <td colspan="3" align="left" valign="top" nowrap="nowrap"><font size="2px">&nbsp;Delivery Agency Name</font> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="21%" height="35"><br /></td>
                                                                        <td width="64%" style="padding-left: 10px;"><img src="./<?php echo $themeUrl; ?>/img/bart_sig.jpg" width="185" height="58" /></td>
                                                                        <td width="15%">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" align="left" valign="top" nowrap="nowrap"><font size="2px">Director - Bart W. Cassidy</font> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="25" colspan="3">
                                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                                <tr>
                                                                                    <td width="22%">&nbsp;</td>
                                                                                    <td width="45%" style="padding-left: 10px;"><img src="./<?php echo $themeUrl; ?>/img/cath_sig.jpg" width="140" height="49" /></td>
                                                                                    <td width="33%">&nbsp;</td>
                                                                                </tr>
                                                                            </table>                                                                            
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" align="left" valign="top" nowrap="nowrap"><font size="2px">Director - Catherine Cassidy</font> </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"  style="width: 100% ">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" style="width: 100%; text-align:center;">Unlawful to Reproduce&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:60%; text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This document has been printed with a security process to deter fraud.</td>
                                                        <td style="width:40%; text-align:right;">American Safety Inc.<img src="./<?php echo $themeUrl; ?>/img/button_copyright.jpg" alt="Edit" width="15" height="15" border="0" />&nbsp;&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table></td>
                                    </tr>
                                </tbody>
                            </table></td>
                    </tr>
                    <tr>
                    </tr>               
                </table>
            </div>
            <div class="certificate-stud-cont">
                <table cellspacing="0" cellpadding="0" height="100" width="900px">
                    <tr>
                        <td align="left" nowrap="nowrap" valign="top" style="text-align:left;font-size: 18px;">
                            <?php echo $first_name; ?>&nbsp;<?php echo $last_name; ?>
                            <?php echo ($std_address != "") ? "<br>" . $std_address : ""; ?>
                            <?php
                            echo ($std_place != "") ? "<br>" . $std_place . "  " : "";
                            echo ($zip != "") ? $zip : "";
                            ?>
                        </td>      
                    </tr>
                </table>
            </div>
            <?php
        }
    }
}
?>

