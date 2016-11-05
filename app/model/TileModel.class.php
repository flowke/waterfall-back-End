<?php

class TileModel extends Model{

    public function addTile($data){
        $sql = "INSERT INTO {$this->table} (tile_title, tile_desc, tile_cover, user_id, category_id) VALUES (?,?,?,?,?)";
        return $this->insert($sql,$data);
    }

    public function getTile($data, $offset=0, $limit=10){
        /* $sql = "SELECT tile.tile_id, tile_title, tile_desc, tile_cover, tile_star, user.user_id, user_name, user_star, category_name, thumb_status FROM tile left join user ON tile.user_id = user.user_id LEFT JOIN category on tile.category_id = category.category_id left join thumb on thumb.user_id = user.user_id AND thumb.tile_id = tile.tile_id LIMIT {$offset}, {$limit}"; */
        $sql = "SELECT tile.tile_id, tile_title, tile_desc, tile_cover, tile_star, user.user_id, user_name, user_star, category_name, thumb_status FROM tile left join user ON tile.user_id = user.user_id LEFT JOIN category on tile.category_id = category.category_id left join thumb on thumb.user_id = ? AND thumb.tile_id = tile.tile_id LIMIT {$offset}, {$limit}";
        return $this->dbClass->getAll($sql,$data);
    }

    public function getUserTile($data, $offset=0, $limit=10){

        $sql = "SELECT tile.tile_id, tile_title, tile_desc, tile_cover, tile_star, user.user_id, user_name, user_star, category_name, thumb_status FROM tile left join user ON tile.user_id = user.user_id LEFT JOIN category on tile.category_id = category.category_id left join thumb on thumb.user_id = ? AND thumb.tile_id = tile.tile_id where tile.user_id = ? LIMIT {$offset}, {$limit}";

        return $this->dbClass->getAll($sql,$data);
    }

    public function updateStar($data,$num){
        $sql = "UPDATE {$this->table} SET tile_star = tile_star+{$num} WHERE tile_id = ?";
        return $this->update($sql,$data);
    }

}
