<?php
namespace app\controller;
use core\base\controller;

class error_controller extends controller{
    /**
     * default
     */
    public function error(){
        $this->not_found();
    }

    public function test(){
        exit("ok");
    }
}