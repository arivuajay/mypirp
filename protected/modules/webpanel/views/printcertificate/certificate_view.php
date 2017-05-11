<?php
$themeUrl = $this->themeUrl;
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
    $std_address = trim($sinfo->address1 . " " . $sinfo->address2);
    $std_place = $sinfo->city . ", " . $sinfo->state . " " . $sinfo->zip;

    $dob = ($sinfo->dob != "0000-00-00") ? Myclass::date_dispformat($sinfo->dob) : "-";
    $gender = ($sinfo->gender == "F") ? "Female" : "Male";
    $licence_number = $sinfo->licence_number;
    $clas_date = ($sinfo->course_completion_date != "0000-00-00") ? Myclass::date_dispformat($sinfo->course_completion_date) : "-";
    ?>

    <div style="width:818px; margin: 0px auto; border:#000000 solid 2px; font-family:'Times New Roman', Times, serif;">
        <table width="100%" border="0" cellspacing="0" cellpadding="20">
            <tr>
                <td align="left">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin:20px;">
                        <tr>
                            <td align="left" style="font-weight:bold; font-size:12pt; font-style:italic;">CERTIFICATE OF COMPLETION</td>
                            <td align="right" style="font-weight:bold; font-size:12pt;">CNO:  #028-0<?php echo $certificate_no; ?></td>
                        </tr>
                        <tr>
                            <td align="left" style="font-weight:bold; font-size:12pt; font-style:italic;"><br><br>AMERICAN SAFETY INC.</td>
                            <td align="right" style="font-weight:bold; font-size:12pt;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="left" style="font-weight:bold; font-size:12pt; font-style:italic;">&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:9pt;"><br><br>Delivery Agency Code: <?php echo $agency_code; ?></td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" style="font-size:9pt"><br><br>This certifies that the person named below has successfully completed American Safety Inc.'s 6-hour Point & Insurance Reduction Program. In compliance with Section 2336 of the New York State Insurance Law.</td>
                        </tr>          
                    </table>
                    <br>
                    <p style="font-size:10pt; font-weight:bold;">
                        American Safety Inc.<br>
                        111 Washington Ave., Ste 606<br>
                        Albany, NY 12210
                    </p>
                    <div>&nbsp;</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin:20px;">
                        <tr>
                            <td align="left" style="font-size:11pt" width="60%">
                                Student DL#: <?php echo $licence_number; ?><br><br>
                                StudentName: <?php echo $first_name; ?>&nbsp;<?php echo ($middle_name!="")?$middle_name."&nbsp;":""; ?><?php echo $last_name; ?><br><br>
                                Date of Birth: <?php echo $dob; ?> &nbsp;&nbsp;&nbsp; Sex: <?php echo $gender; ?><br><br>
                                Course Completion Date: <?php echo $clas_date; ?>
                            </td>
                            <td align="left" style="font-size:10pt;" width="40%">
                                <strong><?php echo $agency_name; ?></strong><br>
                                Delivery Agency Name<br>
                                <img src="<?php echo $themeUrl; ?>/img/bart_sig.jpg" /><br>
                                Director - Bart W. Cassidy<br>
                                <img src="<?php echo $themeUrl; ?>/img/cath_sig.jpg" /><br>
                                Director - Catherine Cassidy
                            </td>
                        </tr>          
                    </table>
                    <div align="center" style="font-size:9pt;">Unlawful to Reproduce </div><br>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin:20px;">
                        <tr>
                            <td align="left" style="font-size:9pt" width="60%">
                                This document has been printed with a security process to deter fraud.
                            </td>
                            <td align="right" style="font-size:9pt;" width="40%">
                                American Safety Inc. &copy;
                            </td>
                        </tr>          
                    </table>
                </td>	
            </tr>
        </table>  	
    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php if (strlen($agency_name) <= 35) {
        ?>   
        <br><br><br>
    <?php } else { ?>
        <br><br> 
    <?php }
    ?>
    <br><br><br><br><span style="font-size:12pt;"><?php echo $first_name; ?>&nbsp;<?php echo ($middle_name!="")?$middle_name."&nbsp;":""; ?><?php echo $last_name; ?><br><?php echo $std_address; ?><br><?php echo $std_place; ?></span>
        <?php
    }
    ?>

