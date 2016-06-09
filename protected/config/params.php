<?php

$whitelist = array('127.0.0.1', '::1');
if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    $mailsendby = 'smtp';
    $adminurl   = 'http://localhost/drivingagency/branches/dev/';

} else {
    $mailsendby  = 'phpmail';
  //  $adminurl   = 'http://webadmin.opti-guide.com/';

}

// Custom Params Value
return array(
    //Global Settings
    'EMAILLAYOUT' => 'file', // file(file concept) or db(db_concept)
    'EMAILTEMPLATE' => '/mailtemplate/',
    
    'MAILSENDBY' => $mailsendby,
    //EMAIL Settings
    'SMTPHOST' => 'smtp.gmail.com',
    'SMTPPORT' => '465', // Port: 465 or 587
    'SMTPUSERNAME' => 'marudhuofficial@gmail.com',
    'SMTPPASS' => 'ninja12345',
    'SMTPAUTH' => true, // Auth : true or false
    'SMTPSECURE' => 'ssl', // Secure :tls or ssl
    'NOREPLYMAIL' => 'noreply@mypirpclass.com',
//    'SITENAME' => 'Optiguide.com',
    'JS_SHORT_DATE_FORMAT' => 'yy-mm-dd',
    'PHP_SHORT_DATE_FORMAT' => 'Y-m-d',

    'ADMIN_EMAIL'   => 'vasanth@arkinfotec.com',
    'EMAILHEADERIMAGE' => '/themes/site/images/header-logo.png',    
    'COPYRIGHT' => '&copy; 2016 MypirpClass.',
    
    'DEFAULTPAYS' => 1,  
    
    'LISTPERPAGE' => 15,
    'PAGE_SIZE' => 15,
  
    // retailer logo path
    'IMG_PATH' => 'uploads/',   
   
);
