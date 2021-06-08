<?php

namespace core\base;

class api{
    private $data = array();
    private $response_code = 500;

    /**
     * 赋值
     * @param $data array 数据
     * @param $code int 状态码
     */
    public function assign($data, $code){
        $this->data = $data;
        $this->response_code = $code;
    }

    public function generate(){
        header("content-type: application/json;charset=utf-8");
        http_response_code($this->response_code);
        exit(json_encode($this->data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }

    public function not_found(){
        header("content-type: application/json;charset=utf-8");
        http_response_code(404);
        exit('{"status":"failed","msg":"not_found"}');
    }

    public function bad_request(){
        header("content-type: application/json;charset=utf-8");
        http_response_code(400);
        exit('{"status":"failed","msg":"Bad request"}');
    }

    public function forbidden(){
        header("content-type: application/json;charset=utf-8");
        http_response_code(403);
        exit('{"status":"failed","msg":"Forbidden"}');
    }

    public function too_many_requests(){
        header("content-type: application/json;charset=utf-8");
        http_response_code(429);
        exit('{"status":"failed","msg":"Too many requests"}');
    }

    public function success(){
        header("content-type: application/json;charset=utf-8");
        http_response_code(200);
        exit('{"status":"success"}');
    }
}