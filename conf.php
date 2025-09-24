<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conf['site_timezone'] = 'Africa/Nairobi';
date_default_timezone_set($conf['site_timezone']);

$conf['site_name'] = 'TaskApp';
$conf['site_url'] = 'http://localhost/TaskApp';
$conf['admin_email'] = 'admin@taskapp.local';

$conf['site_lang'] = 'en';

$conf['db_type'] = 'pdo';
$conf['db_host'] = 'localhost';
$conf['db_user'] = 'root';
$conf['db_pass'] = '';
$conf['db_name'] = 'taskapp_db';

$conf['mail_type']   = 'smtp';
$conf['smtp_host']   = 'smtp.gmail.com';
$conf['smtp_user']   = 'ryankagua@gmail.com'; 
$conf['smtp_pass']   = 'fouwgcdfbeyhyfnk';    
$conf['smtp_port']   = 587;
$conf['smtp_secure'] = 'tls';

$conf['min_password_length'] = 8;
$conf['valid_email_domain'] = ['gmail.com','yahoo.com','outlook.com','hotmail.com'];
