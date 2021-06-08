<?php

namespace core\db;

use core\utilities\mailer\mailer;
use PDO;
use PDOException;

/**
 * Class dbh Database Handler
 */
class dbh{
    private static $pdo = null;

    public static function connect(){
        if (self::$pdo !== null){
            return self::$pdo;
        }

        try {
            $dsn    = sprintf('mysql:host=%s;dbname=%s;charset=%s;port=%s', DB_HOST, DB_NAME, DB_CHARSET, DB_PORT);
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            return self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $option);
        } catch (PDOException $e){
            http_response_code(500);
            ?>
            <!doctype html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>无法连接至MySQL服务</title>
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
                <h1>无法连接至MySQL服务</h1>
                <h3>创建数据库连接时发生错误</h3>
                <p>网站暂时无法访问，已自动向管理员告警。</p>
            </div>
            </body>
            </html>
            <?php
            $mailer = new mailer();
            $mailer->report_error('数据库错误');
            exit();
        }
    }
}