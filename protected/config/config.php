<?php

namespace config;
use core\utilities\RedisStatic;

class config{
    private static $base;

    /**
     * @return mixed
     */
    public static function getBase(){
        return self::$base != null ? self::$base : self::$base = json_decode(RedisStatic::get()->get('JSPastebin:config:config'), true);
    }

    /**
     * @param mixed $base
     */
    public static function setBase($base){
        self::$base = $base;
    }

    private static $admin;

    /**
     * @return mixed
     */
    public static function getAdmin(){
        return self::$admin != null ? self::$admin : self::$admin = json_decode(RedisStatic::get()->get('JSPastebin:config:admin'), true);
    }

    /**
     * @param mixed $admin
     */
    public static function setAdmin($admin){
        RedisStatic::get()->set('JSPastebin:config:admin', json_encode($admin));
        self::$admin = $admin;
    }

    private static $global;

    /**
     * @return mixed
     */
    public static function getGlobal(){
        return self::$global != null ? self::$global : self::$global = json_decode(RedisStatic::get()->get('JSPastebin:config:global'), true);
    }

    /**
     * @param mixed $global
     */
    public static function setGlobal($global){
        RedisStatic::get()->set('JSPastebin:config:global', json_encode($global));
        self::$global = $global;
    }
}