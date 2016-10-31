<?php
/**
 * 基础模型类
 * 定制的模型应该继承此模型
 */
class Model{
    protected $dbClass = null;
    protected $table = null;
    protected $fields = []; //字段列表

    public function __construct($table){
        // $dbconfig['host'] = $GLOBALS['config']['host'];
        // $dbconfig['user'] = $GLOBALS['config']['user'];
        // $dbconfig['password'] = $GLOBALS['config']['password'];
        // $dbconfig['dbname'] = $GLOBALS['config']['dbname'];
        // $dbconfig['port'] = $GLOBALS['config']['port'];
        // $dbconfig['charset'] = $GLOBALS['config']['charset'];

        $this->dbClass = new Mysql($GLOBALS['config']);
        $this->table = $table ;
        // 调用getFields字段
        $this->getFields();

    }

    private function getFields(){
        $sql = "DESC".$this->table;
    }
    /**
     * 自动插入记录
     * @param  [type] $sql  [description]
     * @param  [type] $data [description]
     * @return mixed 成功返回插如的id,失败返回false
     */
    public function insert( $sql, $data ){
        try{
            $stmt = $this->dbClass->execute($sql, $data);
            // 如果插入成功，返回最后插入记录的id
            return $this->dbClass->getInsertId();
        }catch(PDOException $e){
            return false;
        }

    }

    public function update(){}

    public function delete(){}

    public function total(){}
    /**
	 * 分页获取信息
	 * @param $offset int 偏移量
	 * @param $limit int 每次取记录的条数
	 * @param $where string where条件,默认为空
	 */
    public function numTile($offset, $limit,$where = '',$data=null){
        if (empty($where)){
			$sql = "select * from {$this->table} limit $offset, $limit";
		} else {
			$sql = "select * from {$this->table}  where $where limit $offset, $limit";
		}
		return $this->dbClass->getAll($sql,$data);
    }
}
