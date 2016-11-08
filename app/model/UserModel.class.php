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

    /**
     * 登陆时候用
     * @param  [type] $data [description]
     * @return [type]       [description]
     */

    public function getUser($data){
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? LIMIT 1";
        return $this->dbClass->getRow($sql,$data);
    }

    public function getUsersList(){
        $sql = "SELECT tile.user_id, user_name, user_icon, SUM(tile_star) AS user_star FROM tile ,user WHERE tile.user_id = user.user_id GROUP BY tile.user_id ";
        return $this->dbClass->getAll($sql);
    }

    public function updateAvatar($data){
        $sql = "UPDATE {$this->table} SET user_icon = ? WHERE user_id = ?";
        return $this->update($sql, $data);
    }

}
