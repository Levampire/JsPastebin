<?php
namespace app\controller;
use app\model\user;
use config\config;
use core\base\controller;
use core\utilities\verification;

class index_controller extends controller{
    public function index(){
        $user = new user();
        $current_user = $user->get('token', verification::get_current_user()['token']);
        if(!$current_user){
            $this->not_found();
        }
        elseif($current_user['id'] == config::getAdmin()['id']){ //TODO 页面渲染
            $var['users'] = $user->get_all();
            $var['current_user'] = $current_user;
            $var['is_admin'] = $current_user['id'] == config::getAdmin()['id'] ? 1 : 0;
            $var['admin_id'] = config::getAdmin()['id'];
            $var['global'] = config::getGlobal();
            $this->generate_view('home_admin', true, $var);
        }
        else{
            $var['current_user'] = $current_user;
            $var['global'] = config::getGlobal();
            $this->generate_view('home_nonadmin', true, $var);
        }
    }
}