<?php

namespace App\Model;

use Core\Model;

class ClassModel extends Model {
    public $tableName = 'classes';
    public $primaryKey = 'class_id';
    public $limit = 5;

    public function classRules(){
        return [
          'class_name'=>[self::RULE_REQUIRED, [self::RULE_UNIQUE,'field'=>'class_name']],
          'image'=>[self::RULE_IMAGE]
        ];
    }

    public function teacherClasses(){
      $classId = [];
      $this->join = 'inner join subjects s on s.class_id = c.class_id';
      $classes = $this->getData(['teacher_id'=>getUserId()]);

      foreach($classes as $class){
        $classId[] = $class->class_id;
      }

      $classId = array_unique($classId);
      return $classId;
    }

    public function pages($condition = [],$pattern = []){
      $numberOfRows = count($this->getData($condition,$pattern));
      
      $pages = ceil($numberOfRows/$this->limit);
      return $pages;
    }

    public function pagination($condition = [],$requestData,$pattern = []){
      $offset = 0;

      if(isset($requestData['pageNr'])){
          $page = $requestData['pageNr'] - 1;
          $offset = $page * $this->limit;
      }

      $data = $this->getData($condition,$pattern,['limit'=>$this->limit,'offset'=>$offset]);
      return $data;
    }
}