<?php

return array(
    'gii' => 'gii',
    'gii/<controller:\w+>' => 'gii/<controller>',
    'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',  
    
    '/home'=>'/site/default/index',
    '/aboutus'=>'/site/default/aboutus',
    '/contactus'=>'/site/default/contactus',
    '/innercourses/<cid:\w+>'=>'/site/default/innercourses',
    
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
);
