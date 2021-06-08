<?php
namespace core\base;

class controller{
    protected $_controller;
    protected $_action;
    protected $_api;
    protected $_view;

    public function __construct($controller, $action){
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_api = new api();
        $this->_view = new view();
    }

    public function assign($data, $code){
        $this->_api->assign($data, $code);
    }

    public function generate(){
        $this->_api->generate();
    }

    public function not_found(){
        $this->_api->not_found();
    }

    public function bad_request(){
        $this->_api->bad_request();
    }

    public function success(){
        $this->_api->success();
    }

    public function forbidden(){
        $this->_api->forbidden();
    }

    public function redirect($url){
        header("Location: " . $url);
    }

    public function too_many_requests(){
        $this->_api->too_many_requests();
    }


//    public function assign_view($data){
//        $this->_view->assign($data);
//    }

    public function generate_view($layout, $dynamic = false, $variables = array()){
        $this->_view->render($layout, $dynamic, $variables);
    }

}
