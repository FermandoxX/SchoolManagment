<?php
namespace App\Model;

use Core\Model;

class SubjectModel extends Model{
    public $tableName = 'subjects';
    public $primaryKey = 'subject_id';

    // protected $join = [
    //     'left join' => ['classes c on c.class_id = s.class_id',
    //                      'users u on s.teacher_id = u.user_id']
    // ];

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


    public function pages($condition = [],$rowsPerPage,$pattern,$query = null){
        $numberOfRows = count($this->getData($condition,$pattern,[],false,$query));
        
        $pages = ceil($numberOfRows/$rowsPerPage);
        return $pages;
    }
  
    public function pagination($condition = [],$limit,$offset,$pattern,$requestData,$query = null){
        if(isset($requestData['pageNr'])){
            $page = $requestData['pageNr'] - 1;
            $offset = $page * $limit;
        }

        $data = $this->getData($condition,$pattern,['limit'=>$limit,'offset'=>$offset],false,$query);
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
        $query = 'inner join users u on u.class_id = s.class_id';

        $teacherStudents = $this->getData(['teacher_id'=>$teacherId,'subject_id'=>$subject_id],[],[],false,$query);

        foreach($teacherStudents as $teacherStudent){
            $studentsId[] = $teacherStudent->user_id;
        }

        $studentsId = array_unique($studentsId);

        return $studentsId;
    }

    public function studentSubjectsId($studentId){
        $studentsId = [];
        $query = 'inner join users u on u.class_id = s.class_id';

        $studentSubjects = $this->getData(['user_id'=>$studentId],[],[],false,$query);

        foreach($studentSubjects as $studentSubject){
            $studentsId[] = $studentSubject->subject_id;
        }

        $studentsId = array_unique($studentsId);

        return $studentsId;
    }

}