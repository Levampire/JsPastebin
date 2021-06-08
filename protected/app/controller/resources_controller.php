<?php


namespace app\controller;
use app\model\resources;
use app\model\user;
use config\config;
use core\base\controller;
use core\utilities\RedisStatic;
use core\utilities\tools;
use core\utilities\verification;

class resources_controller extends controller{
    public function js(){
        $args = func_get_args();
        $this->main($args);
    }

    public function css(){
        $args = func_get_args();
        $this->main($args);
    }

    public function resources(){
        $args = func_get_args();
        $this->main();
    }

    private function main(){
        $args = func_get_args();
        $resources = new resources();
        if(API_MODE){
            $user = new user();
            $current_user = $user->get('token', verification::get_current_user()['token']);
            if(!$current_user){
                $this->forbidden();
            }
            switch($_SERVER['REQUEST_METHOD']){
                case 'POST':
                    if(!isset($_POST['filename'], $_POST['ext'], $_POST['content']) || !($_POST['filename'] && $_POST['ext'] && $_POST['content'])){
                        $this->bad_request();
                    }
                    if($resources->get_content($_POST['filename'])){
                        $this->bad_request();
                    }

                    $config = config::getGlobal();
                    $custom_flag = false;
                    if(isset($_POST['rate_limit_time_span']) || isset($_POST['rate_limit_limit']) || isset($_POST['cache_max_age']) || isset($_POST['cache_custom'])){
                        $custom_flag = true;
                        $config['rate_limit']['time_span'] = isset($_POST['rate_limit_time_span']) ? $_POST['rate_limit_time_span'] : $config['rate_limit']['time_span'];
                        $config['rate_limit']['limit'] = isset($_POST['rate_limit_limit']) ? $_POST['rate_limit_limit'] : $config['rate_limit']['limit'];
                        $config['cache']['max_age'] = isset($_POST['cache_max_age']) ? $_POST['cache_max_age'] : $config['cache']['max_age'];
                        $config['cache']['custom'] = isset($_POST['cache_custom']) ? $_POST['cache_custom'] : $config['cache']['custom'];
                    }
                    $uploader = $current_user['id'];
                    $timestamp = time();
                    $resources->add($_POST['filename'], $_POST['ext'], $_POST['content'], $uploader, $custom_flag ? json_encode($config, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) : "null", $timestamp);
                    $res['link'] = config::getBase()['site']['url'] . '/resources/' . $_POST['ext'] . '/' . $_POST['filename'];
                    $res['status'] = 'success';
                    $this->assign($res, 200);
                    $this->generate();
                    break;
                case 'GET':
                    if($current_user['id'] != config::getAdmin()['id']){
                        $this->forbidden();
                    }
                    $this->assign($resources->get_all(), 200);
                    $this->generate();
                    break;
            }
            //TODO 对文件进行操作
            $this->success();
        }
        else{
            // 访问具体文件
            if(!isset($args[0][0])){
                $this->not_found();
            }
            $file_arr = $resources->get_content($args[0][0]);
            if(!$file_arr){
                $this->not_found();
            }

            $redis = RedisStatic::get();
            $config = $file_arr['config'] == 'null' ? config::getGlobal() : json_decode($file_arr['config'], true);

            if($config['cdn_mode']){
                header("content-type: text/css; charset=UTF-8");
                exit($file_arr['content']);
            }
            //频率限制
            if($config['rate_limit']['mode']){
                $ip = tools::get_ip();
                $redis_key = 'JSPastebin:rate_limit:' . $ip;
                if(!$redis->exists($redis_key)){
                    $redis->set($redis_key, 0, $config['rate_limit']['time_span']);
                }
                $redis->incr($redis_key);
                if($redis->get($redis_key) > $config['rate_limit']['limit']){
                    $this->too_many_requests();
                }
            }

            if($config['ip_list']['mode'] != 'none'){
                $ip = tools::get_ip();
                if($config['ip_list']['mode'] == 'blacklist'){
                    if(in_array($ip, $config['ip_list']['blacklist'])){
                        $this->forbidden();
                    }
                }
                else{
                    if(in_array($ip, $config['ip_list']['whitelist'])){
                        $this->forbidden();
                    }
                }
            }

            //防盗链
            if($config['anti_leech']['mode'] != 'none'){
                if(!filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)){
                    $this->forbidden();
                }
                $url = $_SERVER['HTTP_REFERER'];
                $url_arr = parse_url($url);
                if($config['anti_leech']['mode'] == 'blacklist'){
                    if(in_array($url_arr['host'], $config['anti_leech']['blacklist'])){
                        $this->forbidden();
                    }
                }
                else{
                    if(!in_array($url_arr['host'], $config['anti_leech']['whitelist'])){
                        $this->forbidden();
                    }
                }
            }

            if($file_arr['ext'] == 'js'){
                header("content-type: text/javascript; charset=UTF-8");
                if($config['cache']['mode'] == 'custom'){
                    header("cache-control: " . $config['cache']['custom']);
                }
                else{
                    header("cache-control: public, max-age=" . $config['cache']['max_age']);
                }
                exit($file_arr['content']);
            }
            else{
                header("content-type: text/css; charset=UTF-8");
                if($config['cache']['mode'] == 'custom'){
                    header("cache-control: " . $config['cache']['custom']);
                }
                else{
                    header("cache-control: public, max-age=" . $config['cache']['max_age']);
                }
                exit($file_arr['content']);
            }
        }
    }

    public function edit(){
        $user = new user();
        $current_user = $user->get('token', verification::get_current_user()['token']);
        if(!$current_user || $current_user['id'] != config::getAdmin()['id']){
            $this->forbidden();
        }
        $this->generate_view('resources');
    }

    public function test(){
        echo time();
    }
}