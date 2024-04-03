<?php

namespace App\Model;

use Core\Model;

class GradeModel extends Model {
  public $tableName = 'grades';
  public $primaryKey = 'grade_id';
  // protected $join = [
  //   'right join' => 'users u on g.student_id = u.user_id',
  //   'inner join' => ['classes c on c.class_id = u.class_id',
  //                    'subjects s on s.subject_id = g.subject_id']
  // ];

  public function gradesRule(){
      return [
        'assigment_grade'=>[self::RULE_REQUIRED,self::RULE_GRADES],
        'midterm_exam_grade'=>[self::RULE_REQUIRED,self::RULE_GRADES],
        'final_exam_grade'=>[self::RULE_REQUIRED,self::RULE_GRADES],
      ];
  }
  
  public function pages($condition = [],$rowsPerPage,$pattern){
      $numberOfRows = count($this->getData($condition,$pattern));
      
      $pages = ceil($numberOfRows/$rowsPerPage);
      return $pages;
  }

  public function pagination($condition = [],$limit,$offset,$pattern,$requestData){
      if(isset($requestData['pageNr'])){
          $page = $requestData['pageNr'] - 1;
          $offset = $page * $limit;
      }

      $data = $this->getData($condition,$pattern,['limit'=>$limit,'offset'=>$offset]);
      return $data;
  }
}