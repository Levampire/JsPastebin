<?php

namespace app\controller;
use app\model\user;
use config\config;
use core\base\controller;
use core\utilities\RedisStatic;
use core\utilities\verification;

class global_controller extends controller{
    /**
     * 全局配置
     */
    public function global(){
        $user = new user();
        $current_user = $user->get('token', verification::get_current_user()['token']);
        if(!$current_user || $current_user['id'] != config::getAdmin()['id']){
            $this->forbidden();
        }
        if(API_MODE){
            $global_config = config::getGlobal();
            switch($_SERVER['REQUEST_METHOD']){
                case 'POST':
                    if(isset($_POST['option']) && $_POST['option'] == 'temp'){
                        // 超级不建议
                        config::setGlobal($_POST['config']);
                        $this->success();
                    }
                    else{
                        $config = config::getGlobal();
                        $config['cdn_mode'] = isset($_POST['cdn_mode']) ? $_POST['cdn_mode'] : $config['cdn_mode'];
                        if($config['cdn_mode']){
                            config::setGlobal($config);
                            $this->success();
                            break;
                        }
                        $config['rate_limit']['mode'] = isset($_POST['rate_limit_mode']) ? $_POST['rate_limit_mode'] : $config['rate_limit']['mode'];
                        if($config['rate_limit']['mode']){
                            $config['rate_limit']['time_span'] = isset($_POST['rate_limit_time_span']) ? $_POST['rate_limit_time_span'] : $config['rate_limit']['time_span'];
                            $config['rate_limit']['limit'] = isset($_POST['rate_limit_limit']) ? $_POST['rate_limit_limit'] : $config['rate_limit']['limit'];
                        }
                        $config['ip_list']['mode'] = isset($_POST['ip_list_mode']) ? $_POST['ip_list_mode'] : $config['ip_list']['mode'];
                        if($config['ip_list']['mode'] == 'blacklist' && isset($_POST['ip_list_blacklist'])){
                            $ip_arr = explode("\n", trim($_POST['ip_list_blacklist']));
                            for($i = 0; $i < count($ip_arr); ++$i){
                                if(!filter_var($ip_arr[$i], FILTER_VALIDATE_IP)){
                                    echo $ip_arr[$i];
                                    $this->bad_request();
                                }
                            }
                            $config['ip_list']['blacklist'] = $ip_arr;
                        }
                        elseif($config['ip_list']['mode'] == 'whitelist' && isset($_POST['ip_list_whitelist'])){
                            $ip_arr = explode("\n", trim($_POST['ip_list_whitelist']));
                            for($i = 0; $i < count($ip_arr); ++$i){
                                // echo $ip_arr[$i];
                                if(!filter_var($ip_arr[$i], FILTER_VALIDATE_IP)){
                                    $this->bad_request();
                                }
                            }
                            $config['ip_list']['whitelist'] = $ip_arr;
                        }
                        $config['anti_leech']['mode'] = isset($_POST['anti_leech_mode']) ? $_POST['anti_leech_mode'] : $config['anti_leech']['mode'];
                        if($config['anti_leech']['mode'] == 'blacklist' && isset($_POST['anti_leech_blacklist'])){
                            $ip_arr = explode("\n", trim($_POST['anti_leech_blacklist']));
                            $config['anti_leech']['blacklist'] = $ip_arr;
                        }
                        elseif($config['anti_leech']['mode'] == 'whitelist' && isset($_POST['anti_leech_whitelist'])){
                            $ip_arr = explode("\n", trim($_POST['anti_leech_whitelist']));
                            $config['anti_leech']['whitelist'] = $ip_arr;
                        }
                        $config['cache']['mode'] = isset($_POST['cache_mode']) ? $_POST['cache_mode'] : $config['cache']['mode'];
                        if($config['cache']['mode'] == 'config'){
                            $config['cache']['max_age'] = isset($_POST['cache_max_age']) ? $_POST['cache_max_age'] : $config['cache']['max_age'];
                        }
                        elseif($config['cache']['mode'] == 'custom'){
                            $config['cache']['custom'] = isset($_POST['cache_custom']) ? $_POST['cache_custom'] : $config['cache']['custom'];
                        }
                        config::setGlobal($config);
                        $this->success();
                    }
                    break;
                case 'GET':
                    $this->assign($global_config, 200);
                    $this->generate();
                    break;
            }
        }
        else{
            $this->generate_view('global');
        }
    }
}