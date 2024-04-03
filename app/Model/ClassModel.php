<?php

namespace App\Model;

use Core\Model;

class ClassModel extends Model {
    public $tableName = 'classes';
    public $primaryKey = 'class_id';

    public function classRules(){
        return [
          'class_name'=>[self::RULE_REQUIRED, [self::RULE_UNIQUE,'field'=>'class_name']],
          'image'=>[self::RULE_IMAGE]
        ];
    }

    public function teacherClasses(){
      $classId = [];
      $query = 'inner join subjects s on s.class_id = c.class_id';
      $classes = $this->getData(['teacher_id'=>getUserId()],[],[],false,$query);

      foreach($classes as $class){
        $classId[] = $class->class_id;
      }

      $classId = array_unique($classId);
      return $classId;
    }

    public function pages($condition = [],$rowsPerPage,$pattern = []){
      $numberOfRows = count($this->getData($condition,$pattern));
      
      $pages = ceil($numberOfRows/$rowsPerPage);
      return $pages;
    }

    public function pagination($condition = [],$limit,$offset,$requestData,$pattern = []){
      if(isset($requestData['pageNr'])){
          $page = $requestData['pageNr'] - 1;
          $offset = $page * $limit;
      }

      $data = $this->getData($condition,$pattern,['limit'=>$limit,'offset'=>$offset]);
      return $data;
    }
}