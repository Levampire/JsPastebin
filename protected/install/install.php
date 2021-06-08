<?php

use core\utilities\tools;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "protected/PHPMailer-6.1.6/src/Exception.php";
require "protected/PHPMailer-6.1.6/src/PHPMailer.php";
require "protected/PHPMailer-6.1.6/src/SMTP.php";
include_once "protected/core/utilities/tools.php";

try{
    $redis = new Redis();
    $redis->connect('localhost', 6379);
}
catch (Exception $e){
    http_response_code(500);
    // exit('{"status":"failed","msg":"Could not establish redis connection"}');
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>无法连接至Redis服务</title>
        <style>
            .container {
                width: 60%;
                margin: 10% auto 0;
                background-color: #f0f0f0;
                padding: 2% 5%;
                border-radius: 10px
            }

            ul {
                padding-left: 20px;
            }

            ul li {
                line-height: 2.3
            }

            a {
                color: #20a53a
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>无法连接至Redis服务</h1>
        <h3>创建Redis连接时发生错误导致软件无法正常安装</h3>
        <ul>
            <li>检查Redis拓展是否配置正确</li>
            <li>检查Redis端口是否为6379</li>
        </ul>
    </div>
    </body>
    </html>
    <?php
    exit();
}

// $redis->connect('localhost', 6379);
/**
 * 安装写配置
 */
if($redis->exists('JSPastebin:config:config')){
    header("content-type: application/json;charset=utf-8");
    http_response_code(404);
    exit('{"status":"failed","msg":"Not found"}');
}
elseif(!$redis->exists('JSPastebin:config:config_temp')){
    // 生成临时配置
    $config_template_str = require('protected/config/config.template.php');
    $redis->set('JSPastebin:config:config_temp', $config_template_str);
}

// print_r($_POST);

if(isset($_POST['module'])){
    header("content-type: application/json;charset=utf-8");
    // POST 提交数据+测试
    switch($_POST['module']){
        case "smtp_verification": // 保存设置并发送验证邮件
            if(!(isset($_POST['host']) && isset($_POST['username']) && isset($_POST['pwd']) && isset($_POST['sender']) && isset($_POST['admin']))){
                http_response_code(400);
                exit('{"status":"failed","msg":"Bad request"}');
            }
            $config_temp_str = $redis->get('JSPastebin:config:config_temp');
            $port = isset($_POST['port']) ? $_POST['port'] : '465';
            $secure = isset($_POST['secure']) ? $_POST['secure'] : 'ssl';

            // 发件
            $verification_code = rand(100000, 999999);
            $mail_str = file_get_contents('protected/core/utilities/mailer/template/verification.html');
            $mail_str = str_replace(array('%site_title%', '%site_url%', '%verification_code%'), array('JSPastebin', '#', $verification_code), $mail_str);
            try{
                $mail = new PHPMailer();
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $_POST['host'];    // Set the SMTP server to send through
                $mail->Timeout    = 10;
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $_POST['username'];                     // SMTP username
                $mail->Password   = $_POST['pwd'];
                $mail->SMTPSecure = $secure;
                // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom($_POST['sender'], 'JSPastebin');
                $mail->CharSet = 'UTF-8';
                $mail->addAddress($_POST['admin']);
                $mail->Subject = '=?UTF-8?B?' . base64_encode('JSPastebin管理员验证') . '?=';
                $mail_content = $mail_str;
                $mail->Body    = $mail_content;
                $mail->AltBody = '验证码：' . $verification_code;
                $redis->set('JSPastebin:verification_code:' . $_POST['admin'], $verification_code, 300);
                $redis->set('JSPastebin:temp:admin_email', $_POST['admin'], 1000);
                $mail->send();
                // exit('{"status":"success"}');
            }
            catch (Exception $e){
                http_response_code(500);
                exit('{"status":"failed","msg":"SMTP config invalid"}');
            }

            $search = array('%smtp_host%', '%smtp_username%', '%smtp_pwd%', '%smtp_port%', '%smtp_secure%', '%smtp_sender%', '%smtp_admin%');
            $replace = array($_POST['host'], $_POST['username'], $_POST['pwd'], $port, $secure, $_POST['sender'], $_POST['admin']);

            $config_temp_str = str_replace($search, $replace, $config_temp_str);

            $redis->set('JSPastebin:config:config_temp', $config_temp_str);
            exit('{"status":"success"}');
            break;

        case 'smtp_confirm':
            if(!isset($_POST['verification_code'])){
                http_response_code(400);
                exit('{"status":"failed","msg":"Bad request"}');
            }
            if($_POST['verification_code'] != $redis->get('JSPastebin:verification_code:' . $redis->get('JSPastebin:temp:admin_email'))){
                http_response_code(403);
                exit('{"status":"failed","msg":"Invalid verification code"}');
            }
            $config_temp_str = $redis->get('JSPastebin:config:config_temp');
            $config_temp_str = str_replace('%base_key%', tools::rand_str(10), $config_temp_str);
            $redis->set('JSPastebin:config:config', $config_temp_str);
            $redis->set('JSPastebin:config:global', json_encode(require('protected/config/global.template.php')));
            $redis->del('JSPastebin:config:config_temp');
            exit('{"status":"success"}');
            break;

        case 'mysql':
            if(!(isset($_POST['dbname']) && isset($_POST['username']) && isset($_POST['pwd']))){
                http_response_code(400);
                exit('{"status":"failed","msg":"Bad request"}');
            }
            $config_temp_str = $redis->get('JSPastebin:config:config_temp');
            $host = isset($_POST['host']) ? $_POST['host'] : 'localhost';
            $port = isset($_POST['port']) ? $_POST['port'] : '3306';
            $charset = isset($_POST['charset']) ? $_POST['charset'] : 'utf8';
            $prefix = isset($_POST['prefix']) ? $_POST['prefix'] : 'fp_';

            $res = array();
            try{
                $dsn    = sprintf('mysql:host=%s;dbname=%s;charset=%s;port=%s', $host, $_POST['dbname'], $charset, $port);
                $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
                $pdo    = new PDO($dsn, $_POST['username'], $_POST['pwd'], $option);
            }
            catch(PDOException $e){
                http_response_code(501);
                exit('{"status":"failed","msg":"Could not establish connection"}');
            }

            $search = array('%db_name%', '%db_username%', '%db_pwd%', '%db_host%', '%db_port%', '%db_charset%', '%db_prefix%');
            $replace = array($_POST['dbname'], $_POST['username'], $_POST['pwd'], $host, $port, $charset, $prefix);

            $config_temp_str = str_replace($search, $replace, $config_temp_str);

            $redis->set('JSPastebin:config:config_temp', $config_temp_str);
            exit('{"status":"success"}');
            break;

        case "url":
            if(!isset($_POST['url'])){
                http_response_code(400);
                exit('{"status":"failed","msg":"Bad request"}');
            }

            try{
                if(file_get_contents($_POST['url'] . '/check_url.txt') != 'JSPastebin:success'){
                    http_response_code(501);
                    exit('{"status":"failed","msg":"URL verification failed"}');
                }
            }
            catch(Exception $e){
                exit('{"status":"failed","msg":"URL verification failed"}');
            }

            $config_temp_str = $redis->get('JSPastebin:config:config_temp');

            $search = array('%site_url%');
            $replace = array($_POST['url']);

            $config_temp_str = str_replace($search, $replace, $config_temp_str);

            $redis->set('JSPastebin:config:config_temp', $config_temp_str);
            exit('{"status":"success"}');
            break;

        default:
            exit('{"status":"failed","msg":"Bad request"}');
            break;
    }
}
else{
    // TODO 显示页面
    include_once('pages/install.html');
}

exit();