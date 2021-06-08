<?php

namespace app\model;

use core\base\model;

class resources extends model{
    public function __construct(){
        $this->table = DB_PREFIX . 'resources';
        $sql = str_replace('%table_name%', $this->table, file_get_contents('protected/sql/js/init.sql'));
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
    }

    public function add($filename, $ext, $content, $uploader, $config, $timestamp){
        $sql = "INSERT INTO " . $this->table . " (filename, ext, content, uploader, config, timestamp) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$filename, $ext, $content, $uploader, $config, $timestamp]);
    }

    public function delete($search_param, $search_value){
        $sql = "DELETE FROM " . $this->table . " WHERE " . $search_param . " = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$search_value]);
    }

    public function set($search_param, $search_value, $set_param, $set_value){
        $sql = "UPDATE " . $this->table . " SET " . $set_param . " = ?" . " WHERE " . $search_param . " = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$set_value, $search_value]);
    }

    public function get_all(){
        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get($search_param, $search_value){
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $search_param . " = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$search_value]);
        return $stmt->fetchAll();
    }

    public function get_content($filename){
        $sql = "SELECT ext, content, config FROM " . $this->table . " WHERE filename = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$filename]);
        $result = $stmt->fetchAll();
        return isset($result[0]) ? $result[0] : null;
    }
}