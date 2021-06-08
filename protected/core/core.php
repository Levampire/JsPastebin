<?php
namespace core;
use core\base\functions;

defined('CORE_PATH') or define('CORE_PATH', __DIR__);

/**
 * Class core
 */
class Core{
    /**
     * @var array configuration array
     */
    protected $config;

    /**
     * Core constructor.
     * @param $config array configuration array
     */
    public function __construct($config){
        $this->config = $config;
    }

    /**
     * Load configurations, route and run
     */
    public function run(){
        spl_autoload_register(array($this, 'loadClass'));
//        $this->first_load();
//        $this->limit_check();
        $this->set_basic_config();;
        $this->set_db_config();
        $this->set_mailer_config();
        // $this->set_other_config();
        $this->route();
    }

    private function first_load(){
//        echo 1;
//        if(!file_exists('config/config.php')){
//            http_response_code(302);
//            header("Location: /install");
//        }
//        if($_SERVER['REQUEST_URI'] == '/install'){
//            exit('install');
//        }
    }

    /**
     * Load basic configurations
     */
    private function set_basic_config(){
        if($this->config['site']){
            define('BASE_TITLE', $this->config['site']['title']);
            define('BASE_URL', $this->config['site']['url']);
        }
    }

    /**
     * Load database(PDO) configurations
     */
    private function set_db_config(){
        if($this->config['mysql']){
            define('DB_HOST', $this->config['mysql']['host']);
            define('DB_NAME', $this->config['mysql']['db_name']);
            define('DB_USER', $this->config['mysql']['username']);
            define('DB_PASS', $this->config['mysql']['pwd']);
            define('DB_PREFIX', $this->config['mysql']['prefix']);
            define('DB_PORT', $this->config['mysql']['port']);
            define('DB_CHARSET', $this->config['mysql']['charset']);
        }
    }

    /**
     * Load PHPMailer configurations
     */
    private function set_mailer_config(){
        if($this->config['smtp']){
            define('MAILER_HOST', $this->config['smtp']['host']);
            define('MAILER_USER', $this->config['smtp']['username']);
            define('MAILER_PASS', $this->config['smtp']['pwd']);
            define('MAILER_SECURE', $this->config['smtp']['secure']);
            define('MAILER_PORT', $this->config['smtp']['port']);
            define('MAILER_SENDER', $this->config['smtp']['sender']);
        }
    }

    /**
     * Load other configurations
     */
    private function set_other_config(){
        if($this->config['cors_allow']){
            define('CORS_ALLOW', $this->config['cors_allow']);
        }
        if($this->config['vaptcha']){
            define('VAPTCHA', $this->config['vaptcha']);
        }
        if($this->config['admin_email']){
            define('ADMIN_EMAIL', $this->config['admin_email']);
        }
    }

    /**
     * Check if current ip exceeded request limit
     */
    private function limit_check(){
        $key= 'request_count_' . functions::get_ip();
        $redis = functions::get_redis();
        $exists = $redis->exists($key);
        $redis->incr($key);

        if($exists){
            $count = $redis->get($key);

            // 这个incr简直太诡异了，每次都加二，不知道原因，希望这背后没有大问题
            // 后续：莫名其妙的好了
            if($count > $this->config['request_limit']['limit']){
                http_response_code(429);
                $res['status'] = 'failed';
                $res['error'] = 'Too many requests';
                exit(json_encode($res));
            }
        }
        else{
            // 首次计数 设定过期时间
            $redis->expire($key, $this->config['request_limit']['ttl']);
            // exit();
        }
    }

    /**
     * Get the controller and action and execute
     */
    private function route(){
        $controller_name = 'error';
        $action_name = 'error';
        $param = array();
        // echo $controller_name . " " . $action_name;

        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');
        $url = $position === false ? $url : substr($url, 0, $position);

        $position = strpos($url, 'index.php');
        if ($position !== false){
            $url = substr($url, $position + strlen('index.php'));
        }
        
        $url = trim($url, '/');

        if ($url){
            $url_array = explode('/', $url);
            $url_array = array_filter($url_array);

            if($url_array[0] == 'api'){ //分流
                define('API_MODE', 1);
                array_shift($url_array);
            }
            else{
                define('API_MODE', 0);
            }
            $controller_name = $url_array[0];
            $action_name = $controller_name;

            array_shift($url_array);
            $action_name = $url_array ? $url_array[0] : $action_name;

            array_shift($url_array);
            $param = $url_array ? $url_array : array();
        }
        else{
            $controller_name = 'index';
            $action_name = 'index';
        }

        $controller = 'app\\controller\\'. $controller_name . '_controller';
        if (!class_exists($controller) || !method_exists($controller, $action_name)){
            $controller = 'app\\controller\\' . 'error' . '_controller';
            $action_name = 'error';
        }

        $dispatch = new $controller($controller_name, $action_name);
        call_user_func_array(array($dispatch, $action_name), $param);

    }


    /**
     * Class loader
     * @param $class_name string class name
     */
    public function loadClass($class_name){
        if(strpos($class_name, '\\') !== false){
            $file = APP_PATH . 'protected/' . str_replace('\\', '/', $class_name) . '.php';
            if(!is_file($file)){
                return;
            }
        }
        else{
            return;
        }

        include $file;
    }
}