<?php

class UserModel extends Model{
    // 验证用户名，密码
    /**
     * [checkUser description]
     * @param  [type] $username [description]
     * @param  [type] $passw    [description]
     * @return arry or null  直接返回数据库查询到到数组
     */
    public function checkUser($data){

        $sql = "SELECT * FROM {$this->table} WHERE user_name = ? AND user_passw = ? LIMIT 1";

        return $this->dbClass->getRow($sql,$data);
    }
    /**
     * 要么返回插入成功的id,要么返回false
     */

    public function registerUser($data){
        $sql = "INSERT INTO {$this->table} (user_name, user_passw, user_icon) VALUES (?,?,?)";
        return $this->insert($sql, $data);
    }

    public function getUser($data){
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? LIMIT 1";
        return $this->dbClass->getRow($sql,$data);
    }
}
