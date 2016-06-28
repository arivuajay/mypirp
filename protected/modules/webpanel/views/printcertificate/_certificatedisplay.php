<?php
$themeUrl = $this->themeUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($themeUrl . '/css/custom.css');

if ($student_id != "") {

    $sinfo = Students::model()->with("dmvAffiliateInfo")->findByPk($student_id);

    if (!empty($sinfo)) {
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
        $std_address = trim($sinfo->address1." ".$sinfo->address2);       
        $city = $sinfo->city;
        $state = $sinfo->state;
        $zip = $sinfo->zip;
        $std_liveplace[] = $city;
        $std_liveplace[] = $state;        
        if(!empty($std_liveplace))
        {    
            $std_place = array_filter($std_liveplace);
            $std_place = implode(" ,",$std_place);
            $std_place = trim($std_place);
        }    
        
        $dob = ($sinfo->dob != "0000-00-00") ? date("m/d/Y", strtotime($sinfo->dob)) : "-";
        $gender = ($sinfo->gender == "F") ? "Female" : "Male";
        $licence_number = $sinfo->licence_number;
        $clas_date = ($sinfo->course_completion_date != "0000-00-00") ? date("m/d/Y", strtotime($sinfo->course_completion_date)) : "-";
        ?>
        <div class="certificate-cont">
            <table width="100" border="0" align="center" cellpadding="0" cellspacing="0" class="cert-table">
                <tr>
                    <td><table width="900px" height="400" border="1" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td align="left" nowrap="nowrap" valign="top" width="50%"><h3><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFICATE
                                                                OF COMPLETION</i></h3></td>
                                                    <td align="center" valign="top" width="40%"><h3>NO:&nbsp;&nbsp;#028-0<?php echo $certificate_no; ?></h3></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" nowrap="nowrap" width="30%"><h3><i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AMERICAN
                                                                SAFETY INC.</i></h3></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td align="center" nowrap="nowrap" valign="top" width="30%"><b>Delivery Agency Code: <?php echo $agency_code; ?></b> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
                                            <tbody>
                                                <tr>
                                                    <td align="left" valign="top" width="90%"><p>This certifies that the person named below has successfully completed American Safety Inc.'s 6-hour Point &amp; Insurance
                                                            Reduction Program. In compliance with Section 2336 of the New York State Insurance Law.</p></td>
                                                </tr>
                                                <tr>
                                                    <td height="18" align="left" valign="top"></td>
                                                </tr>
                                                <tr>
                                                    <td width="90%" height="57" align="left" valign="top"><p><b>American Safety Inc.</b><br />
                                                            <b>111 Washington Ave., Ste 606</b><br />
                                                            <b>Albany, NY 12210</b></p></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="50%">
                                                            <tbody>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student DL#:&nbsp;&nbsp;<?php echo $licence_number; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Student Name:&nbsp;<?php echo $first_name; ?>&nbsp;<?php echo $last_name; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date
                                                                        of Birth:&nbsp;&nbsp;<?php echo $dob; ?>&nbsp;&nbsp;&nbsp;Sex: &nbsp;<?php echo $gender; ?> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" valign="top" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Course Completion Date:&nbsp;<?php echo $clas_date; ?> </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table align="right" border="0" cellpadding="0" cellspacing="0" width="50%">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="top" nowrap="nowrap">&nbsp;</td>
                                                                    <td align="left" valign="top" nowrap="nowrap"><b>&nbsp;&nbsp;&nbsp;<?php echo $agency_name; ?></b></td>
                                                                    <td align="center" valign="top" nowrap="nowrap">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top" nowrap="nowrap">&nbsp;</td>
                                                                    <td align="left" valign="top" nowrap="nowrap"><img src="<?php echo $themeUrl; ?>/img/line.jpg" width="157" height="10" /></td>
                                                                    <td align="center" valign="top" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" align="left" valign="top" nowrap="nowrap"><font size="2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delivery
                                                                        Agency Name</font> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="21%" height="35"><br />                              </td>
                                                                    <td width="64%" style="padding-left: 10px;"><img src="<?php echo $themeUrl; ?>/img/bart_sig.jpg" width="185" height="58" /></td>
                                                                    <td width="15%">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" align="left" valign="top" nowrap="nowrap"><font size="2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Director
                                                                        - Bart W. Cassidy</font> </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="25" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td width="22%">&nbsp;</td>
                                                                                <td width="45%" style="padding-left: 10px;"><img src="<?php echo $themeUrl; ?>/img/cath_sig.jpg" width="140" height="49" /></td>
                                                                                <td width="33%">&nbsp;</td>
                                                                            </tr>
                                                                        </table></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" align="left" valign="top" nowrap="nowrap"><font size="2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Director
                                                                        - Catherine Cassidy</font> </td>
                                                                </tr>
                                                            </tbody>
                                                        </table></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" align="center" valign="top" width="40%">Unlawful 
                                                        to 
                                                        Reproduce&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr> </tr>
                                                <tr>
                                                    <td align="center" nowrap="nowrap" valign="top" width="60%">This document has been printed with a security process to deter fraud.</td>
                                                    <td align="right" valign="top" width="40%">American Safety Inc.<img src="<?php echo $themeUrl; ?>/img/button_copyright.jpg" alt="Edit" width="15" height="15" border="0" />&nbsp;&nbsp;</td>
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
            <table cellspacing="0" cellpadding="0" height="100" align="center" width="900px">
                <tr>
                    <td align="left" nowrap="nowrap" valign="top">
                        <?php echo $first_name; ?>&nbsp;<?php echo $last_name; ?>
                        <?php echo ($std_address!="")?"<br>".$std_address:""; ?>
                        <?php echo ($std_place!="")?"<br>".$std_place."  ":""; 
                        echo ($zip!="")?$zip:"";?>
                    </td>      
                </tr>
            </table>
        </div>
        <?php
    }
}
?>

