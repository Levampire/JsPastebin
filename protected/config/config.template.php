<?php

return json_encode(array(
    // MySQL configuration
    'mysql' => array(
        'host' => '%db_host%',
        'port' => '%db_port%',
        'db_name' => '%db_name%',
        'username' => '%db_username%',
        'pwd' => '%db_pwd%',
        'charset' => '%db_charset%',
        'prefix' => '%db_prefix%'
    ),
    // SMTP configuration
    'smtp' => array(
        'host' => '%smtp_host%',
        'username' => '%smtp_username%',
        'pwd' => '%smtp_pwd%',
        'secure' => '%smtp_secure%',
        'port' => '%smtp_port%',
        'sender' => '%smtp_sender%',
        'admin' => '%smtp_admin%'
    ),
    // basic configuration
    'site' => array(
        'title' => 'JSPastebin',
        'url' => '%site_url%',
    ),
    'base' => array(
        'key' => '%base_key%'
    )
    // redis configuration
//    'redis_info' => array(
//        'host' => '%redis_host%',
//        'port' => '%redis_port%'
//    )
));