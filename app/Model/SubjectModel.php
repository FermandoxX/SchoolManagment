<?php
namespace App\Model;

use Core\Model;

class SubjectModel extends Model{
    public $tableName = 'subjects';
    public $primaryKey = 'subject_id';
    public $limit = 5;

    public function subjectRules(){
        return [
          'subject_name'=>[self::RULE_REQUIRED],
          'class_id'=>[self::RULE_REQUIRED],
          'image'=>[self::RULE_IMAGE],
          'teacher_id'=>[self::RULE_REQUIRED]
        ];
    }

    public function subjectRulesUpdate(){
        return [
          'subject_name'=>[self::RULE_REQUIRED],
          'image'=>[self::RULE_IMAGE]
        ];
    }


    public function pages($condition = [],$pattern = []){
        $numberOfRows = count($this->getData($condition,$pattern));
        
        $pages = ceil($numberOfRows/$this->limit);
        return $pages;
    }
  
    public function pagination($condition = [],$pattern = [],$requestData){
        $offset = 0;

        if(isset($requestData['pageNr'])){
            $page = $requestData['pageNr'] - 1;
            $offset = $page * $this->limit;
        }

        $data = $this->getData($condition,$pattern,['limit'=>$this->limit,'offset'=>$offset]);
        return $data;
    }

    public function teacherSubjectsId($teacherId){
        $subjectsId = [];
        $teacherSubjects = $this->getData(['teacher_id'=>$teacherId]);

        foreach($teacherSubjects as $teacherSubject){
            $subjectsId[] = $teacherSubject->subject_id;
        }

        return $subjectsId;
    }

    public function teacherStudentsId($teacherId,$subject_id){
        $studentsId = [];
        $this->join = 'inner join users u on u.class_id = s.class_id';

        $teacherStudents = $this->getData(['teacher_id'=>$teacherId,'subject_id'=>$subject_id]);

        foreach($teacherStudents as $teacherStudent){
            $studentsId[] = $teacherStudent->user_id;
        }

        $studentsId = array_unique($studentsId);

        return $studentsId;
    }

    public function studentSubjectsId($studentId){
        $studentsId = [];
        $this->join = 'inner join users u on u.class_id = s.class_id';

        $studentSubjects = $this->getData(['user_id'=>$studentId]);

        foreach($studentSubjects as $studentSubject){
            $studentsId[] = $studentSubject->subject_id;
        }

        $studentsId = array_unique($studentsId);

        return $studentsId;
    }

}