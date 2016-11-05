<?php
/**
 * 数据库链接对象
 */
class Mysql{
    protected $db = null;
    protected $sql = null;

    public function __construct($config){
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        $user = isset($config['user']) ? $config['user'] : 'root';
        $password = isset($config['password']) ? $config['password'] : 'hh';
        $dbname = isset($config['dbname']) ? $config['dbname'] : '';
        $port = isset($config['port']) ? $config['port'] : '3306';
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        try{
            $this->db = new PDO("mysql:host=${host}; dbname=${dbname}; port=${port}; charset=${charset}", $user, $password);
        }catch(PDOException $e){
            echo $password;
            echo "数据库链接失败类：".$e->getMessage();
            exit;
        }
    }
    /**
     * 执行sql语句，并返回statement，供其他操作
     * @param  [type] $sql  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function execute($sql, $data=null){

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $stmt;
    }

    /**
     * 获取一条记录
     * 返回一个关联数组
     * @param  [type] $ql [description]
     * @param  array $data [description]
     * @return 数据库到查询结果， 它期望一个数组       [description]
     */
    public function getRow($sql, $data){
        $stmt = $this->execute($sql, $data);
        $ret = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ret;
    }
    /**
     * 获取所有的记录
     * @param  [type] $sql [description]
     * @return 返回所有记录组成的二维数组
     */
    public function getAll($sql,$data=null){
        $stmt = $this->execute($sql, $data);
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    /**
     * 获取上一步insert操作产生的id
     * @return [type] [description]
     */
    public function getInsertId(){
        return $this->db->lastInsertId();
    }
}
