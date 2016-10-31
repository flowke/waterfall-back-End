<?php

class TileModel extends Model{

    public function addTile($data){
        $sql = "INSERT INTO {$this->table} (tile_title, tile_desc, tile_cover, user_id, category_id) VALUES (?,?,?,?,?)";
        return $this->insert($sql,$data);
    }

    public function getTile($offset=0, $limit=10){
        $sql = "select tile_title, tile_desc, tile_cover, tile_star, user_name, category_name from tile, user, category where tile.user_id = user.user_id and tile.category_id = category.category_id limit {$offset}, {$limit}";

        return $this->dbClass->getAll($sql,null);
    }
}
