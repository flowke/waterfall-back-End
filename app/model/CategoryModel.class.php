<?php

class CategoryModel extends Model{
    public function getCategory(){
        $sql = "select * from {$this->table}";
        return $this->dbClass->getAll($sql,null);
    }
}
