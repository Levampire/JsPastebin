<?php
namespace core\utilities;
use core\utilities\mailer\mailer;
use Redis;
use RedisException;

class RedisStatic{
    private static $redis = null;

    public static function get(){
        if (self::$redis !== null){
            return self::$redis;
        }

        $redis = new Redis();
        try{
            $redis->connect('localhost', 6379);
            $error = 0;
            return self::$redis = $redis;
        }
        catch(RedisException $e){
            http_response_code(500);
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
                <h3>创建Redis连接时发生错误</h3>
                <p>网站暂时无法访问，已自动向管理员告警。</p>
            </div>
            </body>
            </html>
            <?php
        }
    }
}