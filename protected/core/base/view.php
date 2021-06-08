<?php
namespace core\base;

class view
{
    // 渲染显示
    public function render($layout, $dynamic = false, $variables = array()){
        if($dynamic){
            extract($variables);
            include_once("protected/dynamic_pages/" . $layout . ".php");
            exit();
        }
        include_once("pages/" . $layout . ".html");
        exit();
    }
}
