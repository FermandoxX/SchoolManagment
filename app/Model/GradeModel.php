<?php

namespace App\Model;

use Core\Model;

class GradeModel extends Model {
  public $tableName = 'grades';
  public $primaryKey = 'grade_id';
  public $limit = 5;

  public function gradesRule(){
      return [
        'assigment_grade'=>[self::RULE_REQUIRED,self::RULE_GRADES],
        'midterm_exam_grade'=>[self::RULE_REQUIRED,self::RULE_GRADES],
        'final_exam_grade'=>[self::RULE_REQUIRED,self::RULE_GRADES],
      ];
  }
  
  public function pages($condition = [],$pattern){
      $numberOfRows = count($this->getData($condition,$pattern));
      
      $pages = ceil($numberOfRows/$this->limit);
      return $pages;
  }

  public function pagination($condition = [],$pattern,$requestData){
    $offset = 0;

    if(isset($requestData['pageNr'])){
      $page = $requestData['pageNr'] - 1;
      $offset = $page * $this->limit;
    }

    $data = $this->getData($condition,$pattern,['limit'=>$this->limit,'offset'=>$offset]);
    return $data;
  }
}