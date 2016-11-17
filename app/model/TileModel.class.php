<?php

class TileModel extends Model{

    public function addTile($data){
        $time = time();
        $sql = "INSERT INTO {$this->table} (tile_title, tile_desc, tile_cover, user_id, category_id, tile_time) VALUES (?,?,?,?,?,{$time})";
        return $this->insert($sql,$data);
    }

    public function getTile($data, $filterType, $sortBy, $order, $offset=0, $limit=10){

        $filterType = $filterType==0 ? '' : "WHERE tile.category_id = {$filterType}";
        $orderStr = "{$sortBy} {$order}";

        $sql = "SELECT tile.tile_id, tile_title, tile_desc, tile_cover, tile_star, user.user_id, user_name, user_star, category_name, thumb_status FROM tile left join user ON tile.user_id = user.user_id LEFT JOIN category on tile.category_id = category.category_id left join thumb on thumb.user_id = ? AND thumb.tile_id = tile.tile_id {$filterType} ORDER BY {$orderStr} LIMIT {$offset}, {$limit}";
        return $this->dbClass->getAll($sql,$data);
    }

    public function getUserTile($data, $filterType, $sortBy, $order, $offset=0, $limit=10){

        $orderStr = "{$sortBy} {$order}";

        $sql = "SELECT tile.tile_id, tile_title, tile_desc, tile_cover, tile_star, user.user_id, user_name, user_star, category_name, thumb_status FROM tile left join user ON tile.user_id = user.user_id LEFT JOIN category on tile.category_id = category.category_id left join thumb on thumb.user_id = ? AND thumb.tile_id = tile.tile_id WHERE tile.user_id = ? AND $filterType ORDER BY {$orderStr} LIMIT {$offset}, {$limit}";

        return $this->dbClass->getAll($sql,$data);
    }
    public function updateStar($data,$num){
        $sql = "UPDATE {$this->table} SET tile_star = tile_star+{$num} WHERE tile_id = ?";
        return $this->update($sql,$data);
    }

    public function getTileById($data){
        $sql = "SELECT tile.tile_id, tile_title, tile_desc, tile_cover, tile_star, user.user_id, user_name, user_star, category_name, thumb_status FROM tile left join user ON tile.user_id = user.user_id LEFT JOIN category on tile.category_id = category.category_id left join thumb on thumb.user_id = ? AND thumb.tile_id = tile.tile_id WHERE tile.tile_id = ? LIMIT 1" ;
        return $this->dbClass->getAll($sql,$data);
    }

    public function dropTile($data){
        $sql = "DELETE FROM {$this->table} WHERE tile_id = ?";
        return $this->delete($sql, $data);
    }

}
