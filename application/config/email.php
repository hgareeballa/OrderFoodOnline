<?php

  $config['protocol']    = 'smtp';
    $config['smtp_host']    = 'mail.myraseed.com';
    $config['smtp_port']    = '26';
    $config['smtp_timeout'] = '17';
    $config['smtp_user']    = 'noreply@myraseed.com';
    $config['smtp_pass']    = 'just4noreply2004';
    $config['charset']    = 'utf-8';
    $config['newline']    = "\r\n";
    $config['mailtype'] = 'text'; // or html
    $config['validation'] = TRUE; // bool whether to validate email or not   

/*
 * What protocol to use?
 * mail, sendmail, smtp
 */
//$config['protocol'] = 'smtp';

/*
 * SMTP server address and port
 */
///$config['smtp_host'] = 'ssl://smtp.gmail.com';
///$config['smtp_port'] = '465';

/*
 * SMTP username and password.
 */
///$config['smtp_user'] = 'h.gareeballa@gmail.com';
///$config['smtp_pass'] = '200phones';
///$config['smtp_timeout'] = '20';
//$config['smtp_crypto']='ssl';

/*
 * Heroku Sendgrid information.
 */
/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = $_SERVER['SENDGRID_USERNAME'];
$config['smtp_pass'] = $_SERVER['SENDGRID_PASSWORD'];
*/
  ////  $config['useragent']           = "CodeIgniter";
     ///   $config['mailpath']            = "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"                       
      //  $config['mailtype'] = 'html';
       // $config['charset']  = 'utf-8';
       // $config['newline']  = "\r\n";
       // $config['wordwrap'] = TRUE;