<?php

/*
 * Our Custom Mail Class
 */

class Sendmail {
    function send($to, $subject, $body, $fromName = '', $from = '', $attachment = null, $path=null) {       
        if (MAILSENDBY == 'phpmail'):
            $this->sendPhpmail($to, $subject, $body, $attachment);
        elseif (MAILSENDBY == 'smtp'):
            Yii::import('application.extensions.phpmailer.JPhpMailer');
            if (empty($from))
                $from = NOREPLYMAIL;
            if (empty($fromName))
                $fromName = SITENAME;

            $mailer = new JPhpMailer;
            $mailer->IsSMTP();
            $mailer->IsHTML(true);
            $mailer->SMTPAuth = SMTPAUTH;
            $mailer->SMTPSecure = SMTPSECURE;
            $mailer->Host = SMTPHOST;
            $mailer->Port = SMTPPORT;
            $mailer->Username = SMTPUSERNAME;
            $mailer->Password = SMTPPASS;
            $mailer->From = $from;
            $mailer->FromName = $fromName;
            $mailer->AddAddress($to);
            // $mailer->

            $mailer->Subject = $subject;
            
            if($attachment!='')
            {    
                $mailer->AddAttachment($attachment);
            }    

            $mailer->MsgHTML($body);

            try {
                $mailer->Send();
            } catch (Exception $exc) {
                return $exc->getTraceAsString();
            }
        endif;
    }

    public function getMessage($body, &$translate) {
       
        if (EMAILLAYOUT == 'file'):         
            $msg_header = file_get_contents(SITEURL . EMAILTEMPLATE . 'header.html');
            $msg_footer = file_get_contents(SITEURL . EMAILTEMPLATE . 'footer.html');  
            $msg_body = file_get_contents(SITEURL . EMAILTEMPLATE . $body . '.html');

            $message_dub = $msg_header . $msg_body . $msg_footer;
         endif;

        $message = $this->translate($message_dub, $translate);
        return $message;
    }

    public function translate($msg_dub, $translate = array()) {
        $def_trans = array(
            "{SITEURL}" => SITEURL,
            "{SITENAME}" => SITENAME,
            "{EMAILHEADERIMAGE}" => Yii::app()->createAbsoluteUrl(EMAILHEADERIMAGE),
            "{CONTACTMAIL}" => CONTACTMAIL,
        );

        $translation = array_merge($def_trans, $translate);
        $message = strtr($msg_dub, $translation);

        return $message;
    }

    function sendPhpmail($to, $subject, $body, $attachment = null) {
       // $headers = 'MIME-Version: 1.0' . "\r\n";
       // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
      //  $headers .= 'From: ' . SITENAME . ' <' . NOREPLYMAIL . '>' . "\r\n";
        
        $uid = md5(uniqid(time()));
        if($attachment!='')
        {   
            $filename = basename($attachment);            
            $file = $attachment;
            $file_size = filesize($file);
            $handle = fopen($file, "r");
            $content = fread($handle, $file_size);
            fclose($handle);
            $content = chunk_split(base64_encode($content));
        }    
        
       
        $header = "From: ".SITENAME." <".NOREPLYMAIL.">\r\n";        
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    
        $nmessage = "--".$uid."\r\n";
        $nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $nmessage .= $body."\r\n\r\n";
        if($attachment!='')
        { 
            $nmessage .= "--".$uid."\r\n";
            $nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; 
            $nmessage .= "Content-Transfer-Encoding: base64\r\n";
            $nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
            $nmessage .= $content."\r\n\r\n";
            $nmessage .= "--".$uid."--";
        }
        
        mail($to, $subject, $nmessage, $header);
    }
}

?>