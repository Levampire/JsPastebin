<?php
/**
 * JSPastebin
 * @version 1.0.0
 */
#        ┏┓　　　┏┓+ +
#　　　┏┛┻━━━┛┻┓ + +
#　　　┃　　　　　　　┃ 　
#　　　┃　　　━　　　┃ ++ + + +
#　　 ████━████ ┃+
#　　　┃　　　　　　　┃ +
#　　　┃　　　┻　　　┃
#　　　┃　　　　　　　┃ + +
#　　　┗━┓　　　┏━┛
#　　　　　┃　　　┃　　　　　　　　　　　
#　　　　　┃　　　┃ + + + +
#　　　　　┃　　　┃　　　　Codes are far away from bugs with the animal protecting　　　
#　　　　　┃　　　┃ + 　　　　神兽保佑,代码无bug　　
#　　　　　┃　　　┃
#　　　　　┃　　　┃　　+　　　　　　　　　
#　　　　　┃　 　　┗━━━┓ + +
#　　　　　┃ 　　　　　　　┣┓
#　　　　　┃ 　　　　　　　┏┛
#　　　　　┗┓┓┏━┳┓┏┛ + + + +
#　　　　　　┃┫┫　┃┫┫
#　　　　　　┗┻┛　┗┻┛+ + + +


include_once 'cors.php';

// session_start();
define('APP_PATH', __DIR__ . '/');

// error_reporting(0);

// define('APP_DEBUG', true);

$url = $_SERVER['REQUEST_URI'];
$position = strpos($url, '?');
$url = $position === false ? $url : substr($url, 0, $position);
$redis = new Redis();
$redis->connect('localhost', 6379);

if($url == '/install'){
    include_once 'protected/install/install.php';
}
if(!$redis->exists('JSPastebin:config:config')){
    http_response_code(302);
    header("Location: /install");
}

//if(!$redis->exists('JSPastebin:config:global')){
//    http_response_code(302);
//    header("Location: /global-config");
//}

else{
    $config = json_decode($redis->get('JSPastebin:config:config'), true);

    require(APP_PATH . 'protected/core/core.php');

    try{
        (new core\Core($config))->run();
        $error = error_get_last();
        if($error){
            throw new Exception($error['message']);
        }
    }
    catch (Exception $e){
        echo $e;
        http_response_code(500);
        exit('{"status":"failed","error":"500 Internal error"}');
    }
    exit();
}
//  echo $_SERVER['REQUEST_URI'];



//// (new core\Core($config))->run();