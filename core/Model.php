<?php
namespace Core;
use Core\Validation;
use Config\Config;
use PDO;

class Model extends Validation{

    public $tableName = 'users';
    public $primaryKey = 'user_id';
    private $pdo;
    private $statement;
    public $join;

    public function __construct(){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=UTF8";
        $user = DB_USER;
        $password = DB_PASS;
        $this->pdo = new PDO($dsn,$user,$password);
         
        try {
            new PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getDataById($id){
        $sql = "select * from $this->tableName where $this->primaryKey = :$this->primaryKey";
        
        $this->query($sql);
        $this->bind(":$this->primaryKey",$id);
        $this->execute();

        return $this->fetch();
    }

    public function getData($data = [], $pattern = [], $limit = [],$distinct = []){
        $sql = "select * from $this->tableName {$this->tableName[0]}";   

        if(!empty($distinct)){
            $columns = '';

            foreach($distinct as $value){
                $columns .= $value.' ,';
            }
            
            $columns = $this->removeLastWord($columns);

            $sql = str_replace('*','DISTINCT '.$columns,$sql);
        }

        if($this->join != null){
            $sql .= " $this->join ";
        }

        if(!empty($data)){
            $dataCondition = '';

            foreach($data as $columnsNames => $columnsValues){
                $columnName = str_replace('.','',$columnsNames);

                $dataCondition .= " $columnsNames = :$columnName and ";
            }
            $dataCondition = $this->removeLastWord($dataCondition);

            $sql .=" where ".$dataCondition;
        }

        if(!empty($pattern)){

            $patternCondition = '';

            foreach($pattern as $columnsNames => $columnsValues){
                $patternCondition .= " $columnsNames like :".$columnsNames." or ";
            }
            $patternCondition = $this->removeLastWord($patternCondition);

            $condition =" and (".$patternCondition.' )';

            if(!empty($pattern) && empty($data)){
                $condition =" where ".$patternCondition;
            }               
            
            $sql .=" ".$condition;
        }

        if(!empty($limit)){
            foreach($limit as $key => $value){
               $sql .= " $key $value ";
            }
        }

        $this->query($sql);

        foreach($data as $columnsNames => $columnsValues){
            $columnsNames = str_replace('.','',$columnsNames);
            $this->bind(":$columnsNames",$columnsValues);
        }

        foreach($pattern as $columnsNames => $columnsValues){
            $columnsValues = "%$columnsValues%";
            $this->bind(":$columnsNames",$columnsValues);
        }

        $this->execute();
        return $this->fetchAll();
    }

    public function updateDataById($id, $data) {
        $setCondition = '';
        $whereCondition = '';
            
        foreach ($data as $columnName => $columnValue) {
            $setCondition .= "$columnName = :$columnName , ";
        }
    
        $setCondition = $this->removeLastWord($setCondition);
        $whereCondition .= "$this->primaryKey = :$this->primaryKey";
        $sql = "UPDATE $this->tableName SET $setCondition WHERE $whereCondition";
           
        $this->query($sql);
        $this->bind(":$this->primaryKey", $id);
         
        foreach ($data as $columnName => $columnValue) {
            $this->bind(":$columnName", $columnValue);
        }
        $this->execute();

    }

    public function updateData($conditions, $data) {
       
        $setCondition = '';
        $whereCondition = '';

        foreach ($data as $columnName => $columnValue) {
            $setCondition .= "$columnName = :$columnName , ";
        }

        $setCondition = $this->removeLastWord($setCondition, ', ');

        foreach ($conditions as $columnName => $columnValue) {
            $whereCondition .= "AND $columnName = :where_$columnName ";
        }

        $whereCondition = ltrim($whereCondition, 'AND ');

        $sql = "UPDATE $this->tableName SET $setCondition WHERE $whereCondition";
        $this->query($sql);

        foreach ($conditions as $columnName => $columnValue) {
            $this->bind(":where_$columnName", $columnValue);
        }

        foreach ($data as $columnName => $columnValue) {
            $this->bind(":$columnName", $columnValue);
        }
        $this->execute();
    }
    
    public function insertData($data){
        $columns = '';
        $bindValues = '';
        foreach($data as $columnsNames => $columnsValues){
            $columns .= "$columnsNames , ";
        }
        $columns = $this->removeLastWord($columns);
     
        foreach($data as $columnsNames => $columnsValues){
            $bindValues .= ":$columnsNames , ";
        }
        $bindValues = $this->removeLastWord($bindValues);
    
        $sql = "insert into $this->tableName($columns) values($bindValues)";
        $this->query($sql);
     
        foreach($data as $columnsNames => $columnsValues){
            $this->bind(":$columnsNames",$columnsValues);
        }   
    
        $this->execute();
    }

    public function delete($id){
            $sql = "Delete from $this->tableName where $this->primaryKey = :$this->primaryKey";

            $this->query($sql);
            $this->bind(":$this->primaryKey",$id);
            $this->execute();
    }

    private function removeLastWord($sentence){
        $sentence = trim($sentence);

        $sentence = explode(' ', $sentence);
        array_pop($sentence);
        $result = implode(' ', $sentence);    

        return $result;
    }

    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case(is_int($value)):
                    $type = PDO::PARAM_INT;
                break;
                case(is_bool($value)):
                    $type = PDO::PARAM_BOOL;
                break;
                case(is_null($value)):
                    $type = PDO::PARAM_NULL;
                break;
                default:
                    $type = PDO::PARAM_STR;
                break;
            }
        }
        $this->statement->bindValue($param,$value,$type);
    }

    public function query($sql){
        $this->statement = $this->pdo->prepare($sql);
    }

    public function execute(){
        return $this->statement->execute();
    }

    public function fetchAll(){
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetch(){
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }
}
?>