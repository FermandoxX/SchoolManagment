<?php
namespace App\Controller;

use App\Model\UserModel;

class Main {

    public UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;

    }

    public function index(){
        $adminNumber = count($this->userModel->getData(['role_name'=>'admin']));
        $teacherNumber = count($this->userModel->getData(['role_name'=>'teacher']));
        $studentNumber = count($this->userModel->getData(['role_name'=>'student']));

        $this->userModel->join = 'inner join classes c on c.class_id = u.class_id';
        $students = $this->userModel->getData();
        $classesData = [];

        foreach ($students as $student) {
            $className = $student->class_name;
            if (isset($classesData[$className])) {
                $classesData[$className]++;
            } else {
                $classesData[$className] = 1;
            }
        }

        $this->userModel->join = 'inner join attendance a on a.student_id = u.user_id
        inner join classes c on c.class_id = u.class_id';
        $students = $this->userModel->getData();
        $attendancesData = [];
        
        foreach ($students as $student) {
            $className = $student->class_name;
            if (isset($attendancesData[$className])) {
                $attendancesData[$className]++;
            } else {
                $attendancesData[$className] = 1;
            }
        }

        $teachersData = $this->userModel->getData(['role_name'=>'teacher']);
        $teachersDate = [];

        $studentsData = $this->userModel->getData(['role_name'=>'student']);
        $studentsDate = [];

        foreach ($teachersData as $teacherData) {
            $createdDate = date("Y", strtotime($teacherData->create_at));
            if (isset($teachersDate[$createdDate])) {
                $teachersDate[$createdDate]++;
            } else {
                $teachersDate[$createdDate] = 1;
            }
        }

        foreach ($studentsData as $studentData) {
            $createdDate =  date("Y", strtotime($studentData->create_at));
            if (isset($studentsDate[$createdDate])) {
                $studentsDate[$createdDate]++;
            } else {
                $studentsDate[$createdDate] = 1;
            }
        }

        ksort($teachersDate);
        ksort($studentsDate);

        $teachersDate = array_values($teachersDate);
        $studentsDate = array_values($studentsDate);

        return view('main',['adminNumber'=>$adminNumber,'teacherNumber'=>$teacherNumber,'studentNumber'=>$studentNumber,'classesData'=>$classesData,'attendancesData'=>$attendancesData,'teachersCreateDate'=>$teachersDate,'studentsCreateDate'=>$studentsDate]);
    }
}