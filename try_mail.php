<?php
require 'ClassAutoLoad.php';

$mailCnt = [
    'name_from' => 'Ryan',
    'mail_from' => 'ryankagua@gmail.com', 
    'name_to' => 'kagz',
    'mail_to' => 'ryan.mbugua@strathmore.edu',
    'subject' => 'Hello From ICS B',
    'body' => 'Welcome to ICS B! <br> This is a new semester. Let\'s have fun together.'
];

$ObjSendMail->Send_Mail($conf, $mailCnt);
