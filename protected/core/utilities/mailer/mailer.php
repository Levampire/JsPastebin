<?php

namespace core\utilities\mailer;
use core\utilities\tools;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use config\config;
require "protected/PHPMailer-6.1.6/src/Exception.php";
require "protected/PHPMailer-6.1.6/src/PHPMailer.php";
require "protected/PHPMailer-6.1.6/src/SMTP.php";

/*
 * mail类
 */
class mailer{
    private $mail;

    /**
     * 初始化
     * @return bool
     */
    public function init(){
        $this->mail = new PHPMailer(true);
        try {
            $this->mail->isSMTP();                                            // Send using SMTP
            $this->mail->Host       = MAILER_HOST;    // Set the SMTP server to send through
            $this->mail->Timeout    = 10;
            $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $this->mail->Username   = MAILER_USER;                     // SMTP username
            $this->mail->Password   = MAILER_PASS;
            $this->mail->SMTPSecure = MAILER_SECURE;
            // $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port       = MAILER_PORT;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $this->mail->setFrom(MAILER_SENDER, BASE_TITLE);
            $this->mail->CharSet = 'UTF-8';
            return true;
        }
        catch (Exception $e){
            echo $e;
            return false;
        }
    }

    public function send_token($target, $token){
        try{
            if(!$this->init()){
                return false;
            }
            $token = config::getBase()['site']['url'] . '/user/login?token=' . $token;
            $this->mail->addAddress($target);
            $mail_str = file_get_contents('protected/core/utilities/mailer/template/token.html');
            // $mail_str = file_get_contents('protected/core/utilities/mailer/template/verification.html');
            $mail_str = str_replace(array('%site_title%', '%site_url%', '%token%'), array(config::getBase()['site']['title'], config::getBase()['site']['url'], $token), $mail_str);
            $this->mail->Subject = '=?UTF-8?B?' . base64_encode('JSPastebin令牌登陆链接') . '?=';
            $mail_content = $mail_str;
            $this->mail->Body    = $mail_content;
            $this->mail->AltBody = '令牌登录链接：' . $token;
            return $this->mail->send();
        }
        catch(Exception $e){
            echo $e;
            return false;
        }
    }

    public function report_error($error_name){
        try{
            if(!$this->init()){
                return false;
            }
            $this->mail->addAddress(config::getAdmin()['email']);
            $mail_str = file_get_contents('protected/core/utilities/mailer/template/error_report.html');
            // $mail_str = file_get_contents('protected/core/utilities/mailer/template/verification.html');
            $mail_str = str_replace(array('%site_title%', '%site_url%', '%error_name%', '%ip%'), array(config::getBase()['site']['title'], config::getBase()['site']['url'], $error_name, tools::get_ip()), $mail_str);
            $this->mail->Subject = '=?UTF-8?B?' . base64_encode('JSPastebin' . $error_name) . '?=';
            $mail_content = $mail_str;
            $this->mail->Body    = $mail_content;
            $this->mail->AltBody = 'JSPastebin' . $error_name;
            return $this->mail->send();
        }
        catch(Exception $e){
            // echo $e;
            return false;
        }
    }
}
