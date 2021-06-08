<?php

namespace app\controller;
use core\base\controller;
use core\utilities\RedisStatic;
use core\utilities\mailer\mailer;
use core\utilities\tools;
use app\model\user;
use config\config;
use core\utilities\verification;

class user_controller extends controller{
    public function admin(){
        $redis = RedisStatic::get();
        if($redis->exists('JSPastebin:config:admin')){
            $this->not_found();
        }
        $admin_email = config::getBase()['smtp']['admin'];
        $token = tools::rand_str(32);
        $user = new user();
        $user->add('admin', $admin_email, $token);
        $admin_conf = $user->get('token', $token);
        config::setAdmin($admin_conf);
        $mailer = new mailer();
        $mailer->send_token($admin_email, $token);
        $this->success();
    }

    public function login(){
        if(!isset($_GET['token'])){
            $this->not_found();
        }
        $user = new user();
        $current_user = $user->get('token', $_GET['token']);
        if($current_user == null){
            $this->not_found();
        }
        //aes加密入cookie
        verification::login($current_user);
        $this->redirect('/');
    }

    public function logout(){
        verification::logout();
    }

    public function user(){
        $user = new user();
        $current_user = $user->get('token', verification::get_current_user()['token']);
        if(!$current_user){
            $this->forbidden();
        }
        $mailer = new mailer();
        if((isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) || (isset($_POST['username']) && !$_POST['username'])){
            $this->bad_request();
        }
        switch($_SERVER['REQUEST_METHOD']){
            case 'POST': //添加用户
                if($_POST['method'] == 'PUT'){ //TODO 解决请求方式问题后更改
                    if($current_user['id'] == config::getAdmin()['id'] && isset($_POST['id']) && $_POST['id'] != config::getAdmin()['id']){
                        // 改别人的
                        if(isset($_POST['email']) || isset($_POST['username'])){
                            if(isset($_POST['username'])){
                                if($user->get('username', $_POST['username'])){
                                    $this->bad_request();
                                }
                                $user->set('id', $_POST['id'], 'username', $_POST['username']);
                                if($_POST['id'] == config::getAdmin()['id'] && isset($_POST['username'])){
                                    $admin_config = config::getAdmin();
                                    $admin_config['username'] = $_POST['username'];
                                    config::setAdmin($admin_config);
                                }
                            }
                            if(isset($_POST['email'])){
                                if($user->get('email', $_POST['email'])){
                                    $this->bad_request();
                                }
                                $token = tools::rand_str(32);
                                $mailer->send_token($_POST['email'], $token);
                                $user->set('id', $_POST['id'],'email', $_POST['email']);
                                $user->set('id', $_POST['id'],'token', $token);
                            }
                        }
                        elseif(isset($_POST['token'])){
                            $token = tools::rand_str(32);
                            $target_user = $user->get('id', $_POST['id']);
                            $mailer->send_token($target_user['email'], $token);
                            $user->set('id', $_POST['id'],'token', $token);
                            if($_POST['id'] == config::getAdmin()['id']){
                                $admin_config = config::getAdmin();
                                $admin_config['email'] = isset($_POST['email']) ? $_POST['email'] : config::getAdmin()['email'];
                                $admin_config['token'] = $token;
                                config::setAdmin($admin_config);
                                verification::logout();
                            }
                        }
                        else{
                            $this->bad_request();
                        }
                    }
                    elseif(isset($_POST['email']) || isset($_POST['username'])){
                        //改自己的
                        if(isset($_POST['username'])){
                            if($user->get('username', $_POST['username'])){
                                $this->bad_request();
                            }
                            $user->set('id', $current_user['id'], 'username', $_POST['username']);
                            if($current_user['id'] == config::getAdmin()['id']){
                                $admin_config = config::getAdmin();
                                $admin_config['username'] = $_POST['username'];
                                config::setAdmin($admin_config);
                            }
                        }
                        if(isset($_POST['email'])){
                            if($user->get('email', $_POST['email'])){
                                $this->bad_request();
                            }
                            $token = tools::rand_str(32);
                            $mailer->send_token($_POST['email'], $token);
                            $user->set('id', $current_user['id'],'email', $_POST['email']);
                            $user->set('id', $current_user['id'],'token', $token);
                            if($current_user['id'] == config::getAdmin()['id']){
                                $admin_config = config::getAdmin();
                                $admin_config['email'] = $_POST['email'];
                                $admin_config['token'] = $token;
                                config::setAdmin($admin_config);
                            }
                            verification::logout();
                        }
                    }
                    elseif(isset($_POST['token'])){
                        $token = tools::rand_str(32);
                        $mailer->send_token($current_user['email'], $token);
                        $user->set('id', $current_user['id'],'token', $token);
                        if($current_user['id'] == config::getAdmin()['id']){
                            $admin_config = config::getAdmin();
                            $admin_config['token'] = $token;
                            config::setAdmin($admin_config);
                        }
                        verification::logout();
                    }
                    else{
                        $this->bad_request();
                    }
                    $this->success();
                    break;
                }
                elseif($_POST['method'] == 'DELETE'){
                    if($current_user['id'] != config::getAdmin()['id']){
                        $this->forbidden();
                    }
                    if(!isset($_POST['id'])){
                        $this->bad_request();
                    }
                    if($_POST['id'] == config::getAdmin()['id']){
                        $this->bad_request();
                    }
                    $user->delete('id', $_POST['id']);
                    $this->success();
                    break;
                }
                if($current_user['id'] != config::getAdmin()['id']){
                    $this->forbidden();
                }
                if(!(isset($_POST['username'], $_POST['email']))){
                    $this->bad_request();
                }
                $token = tools::rand_str(32);
                if($user->get('username', $_POST['username']) || $user->get('email', $_POST['email'])){
                    $this->bad_request();
                }
                $user->add($_POST['username'], $_POST['email'], $token);
                $mailer->send_token($_POST['email'], $token);
                $this->success();
                break;
            case 'DELETE':
                if($current_user['id'] != config::getAdmin()['id']){
                    $this->forbidden();
                }
                if(!isset($_REQUEST['id'])){
                    $this->bad_request();
                }
                if($_REQUEST['id'] == config::getAdmin()['id']){
                    $this->bad_request();
                }
                $user->delete('id', $_REQUEST['id']);
                $this->success();
                break;
            case 'PUT': //TODO 管理员修改
                if($current_user['id'] == config::getAdmin()['id'] && isset($_REQUEST['id']) && $_REQUEST['id'] != config::getAdmin()['id']){
                    // 改别人的
                    if(isset($_REQUEST['email']) || isset($_REQUEST['username'])){
                        if(isset($_REQUEST['username'])){
                            if($user->get('username', $_POST['username'])){
                                $this->bad_request();
                            }
                            $user->set('id', $_REQUEST['id'], 'username', $_REQUEST['username']);
                            if($current_user['id'] == config::getAdmin()['id']){
                                $admin_config = config::getAdmin();
                                $admin_config['username'] = $_REQUEST['username'];
                                config::setAdmin($admin_config);
                            }
                        }
                        if(isset($_REQUEST['email'])){
                            if($user->get('email', $_POST['email'])){
                                $this->bad_request();
                            }
                            $token = tools::rand_str(32);
                            $mailer->send_token($_REQUEST['email'], $token);
                            $user->set('id', $_REQUEST['id'],'email', $_REQUEST['email']);
                            $user->set('id', $_REQUEST['id'],'token', $token);
                        }
                    }
                    elseif(isset($_REQUEST['token'])){
                        $token = tools::rand_str(32);
                        $mailer->send_token($current_user['email'], $token);
                        $user->set('id', $_REQUEST['id'],'token', $token);
                        if($_REQUEST['id'] == config::getAdmin()['id']){
                            $admin_config = config::getAdmin();
                            $admin_config['email'] = isset($_REQUEST['email']) ? $_REQUEST['email'] : config::getAdmin()['email'];
                            $admin_config['token'] = $token;
                            config::setAdmin($admin_config);
                            verification::logout();
                        }
                    }
                    else{
                        $this->bad_request();
                    }
                }
                elseif(isset($_REQUEST['email']) || isset($_REQUEST['username'])){
                    //改自己的
                    if(isset($_REQUEST['username'])){
                        if($user->get('username', $_POST['username'])){
                            $this->bad_request();
                        }
                        $user->set('id', $current_user['id'], 'username', $_REQUEST['username']);
                        if($current_user['id'] == config::getAdmin()['id']){
                            $admin_config = config::getAdmin();
                            $admin_config['username'] = $_REQUEST['username'];
                            config::setAdmin($admin_config);
                        }
                    }
                    if(isset($_REQUEST['email'])){
                        if($user->get('email', $_POST['email'])){
                            $this->bad_request();
                        }
                        $token = tools::rand_str(32);
                        $mailer->send_token($_REQUEST['email'], $token);
                        $user->set('id', $current_user['id'],'email', $_REQUEST['email']);
                        $user->set('id', $current_user['id'],'token', $token);
                        if($current_user['id'] == config::getAdmin()['id']){
                            $admin_config = config::getAdmin();
                            $admin_config['email'] = $_REQUEST['email'];
                            $admin_config['token'] = $_REQUEST['token'];
                            config::setAdmin($admin_config);
                        }
                        verification::logout();
                    }
                }
                elseif(isset($_REQUEST['token'])){
                    $token = tools::rand_str(32);
                    $mailer->send_token($current_user['email'], $token);
                    $user->set('id', $current_user['id'],'token', $token);
                    if($current_user['id'] == config::getAdmin()['id']){
                        $admin_config = config::getAdmin();
                        $admin_config['token'] = $_REQUEST['token'];
                        config::setAdmin($admin_config);
                    }
                    verification::logout();
                }
                else{
                    $this->bad_request();
                }
                $this->success();
                break;
            case 'GET':
                if(API_MODE){
                    if($current_user['id'] != config::getAdmin()['id'] || (isset($_GET['option']) && $_GET['option'] == 'self')){
                        $res = $current_user;
                        $res['token_link'] = config::getBase()['site']['url'] . '/login?token=' . $current_user['token'];
                        $this->assign($res, 200);
                        $this->generate();
                    }
                    $this->assign($user->get_all(), 200);
                    $this->generate();
                }
                else{
                    if($current_user['id'] != config::getAdmin()['id']){
                        $this->generate_view('nonadmin_user');
                    }
                    else{
                        if($_GET['encode'] == 'html'){
                            $var['users'] = $user->get_all();
                            $var['current_user'] = $current_user;
                            $var['is_admin'] = $current_user['id'] == config::getAdmin()['id'] ? 1 : 0;
                            $var['admin_id'] = config::getAdmin()['id'];
                            $this->generate_view('users_table', true, $var);
                        }
                        $this->generate_view('admin_user');
                    }
                }
                break;
        }
        $this->bad_request();
    }
}