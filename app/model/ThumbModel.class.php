<?php

class ThumbModel extends Model{

    public function checkThumb($data){
        $sql = "SELECT thumb_id FROM {$this->table} WHERE tile_id = ? AND user_id = ? LIMIT 1";
        return $this->dbClass->getAll($sql, $data);
    }

    /**
     * 进行thumb时的更新,thumb 或 unthumb
     * data的顺序应该为 状态， 用户id， tile id
     */
    public function updateThumbStatus($data){
        $sql = "UPDATE {$this->table} SET thumb_status = ? WHERE thumb_id = ?";
        return $this->update($sql, $data);
    }
    /**
     * 添加一个thumb记录
     * data的顺序应该为 tile id, user_id
     */
    public function addThumbRecord($data){
        $sql = "INSERT INTO {$this->table} (tile_id, user_id) VALUES (?,?)";
        return $this->insert($sql, $data);
    }

    public function deleteThumbRecord($data){
        $sql = "DELETE FROM {$this->table} WHERE tile_id = ? AND user_id = ?";
        return $this->delete($sql,$data);
    }

    public function dropThumb($data){
        $sql = "DELETE FROM {$this->table} WHERE tile_id = ?";
        return $this->delete($sql,$data);
    }
}
