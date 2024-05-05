<?php 

namespace App\Model;

use Core\Model;

class AttendanceModel extends Model {
    public $tableName = 'attendance';
    public $primaryKey = 'attendance_id';
    public $limit = 5;

    public function attendanceRules(){
        return [
          'attendance_date'=>[self::RULE_REQUIRED,self::RULE_DATE],
          'month'=>[self::RULE_REQUIRED],
          'year'=>[self::RULE_REQUIRED],
        ];
    }

    public function existAttendance($data){
      foreach($data['checkbox'] as $studentId){
        $studentsData = $this->getData(['student_id'=>$studentId,'subject_id'=>$data['subject_id']]);

        foreach($studentsData as $studentData){
          if(strtotime($studentData->attendance_date) == strtotime($data['attendance_date'])){
            $key = array_search($studentData->student_id,$data['checkbox']);
            unset($data['checkbox'][$key]);
          } 
        }
      }

      return $data['checkbox'];
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

    
    public function teacherAttendancesId($teacherId){
      $teacherAttendancesId = [];
      $this->join = 'inner join subjects s on a.subject_id = s.subject_id';
      $teacherAttendances = $this->getData(['teacher_id'=>$teacherId]);

      foreach($teacherAttendances as $teacherAttendance){
        $teacherAttendancesId[] = $teacherAttendance->attendance_id;
      }

      return $teacherAttendancesId;
    }
}