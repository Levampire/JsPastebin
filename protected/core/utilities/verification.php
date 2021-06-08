<?php


namespace core\utilities;


use config\config;

class verification{
    public static function login($info){
        $key = config::getBase()['base']['key'];
        $userinfo = openssl_encrypt(serialize($info), 'AES-128-ECB', $key, 0);
        $infodig = md5($userinfo . $key);
        setcookie('userinfo', $userinfo, time() + 99999 * 1440 * 60, "/", "", true, true);
        setcookie('infodig', $infodig, time() + 99999 * 1440 * 60, "/", "", true, true);
    }

    public static function get_current_user(){
        $key = config::getBase()['base']['key'];
        if(!isset($_COOKIE['userinfo']) || !isset($_COOKIE['infodig'])){
            return false;
        }
        $userinfo = openssl_decrypt($_COOKIE['userinfo'], 'AES-128-ECB', $key, 0);
        $infodig = $_COOKIE['infodig'];
        if(md5($_COOKIE['userinfo'] . $key) != $infodig){
            return false;
        }
        $userinfo = unserialize($userinfo);
        return $userinfo;
    }

    public static function logout(){
        setcookie('userinfo', 'null', time() - 99999 * 1440 * 60, "/", "", true, true);
        setcookie('infodig', 'null', time() - 99999 * 1440 * 60, "/", "", true, true);
    }
}