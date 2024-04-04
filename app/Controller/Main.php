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
        $classesData = $this->getDataForObjectByName($students,'class_name');

        $this->userModel->join = 'inner join attendance a on a.student_id = u.user_id
        inner join classes c on c.class_id = u.class_id';
        $students = $this->userModel->getData();
        $attendancesData = $this->getDataForObjectByName($students,'class_name');
        
        $this->userModel->join = null;
        $teachersData = $this->userModel->getData(['role_name'=>'teacher']);
        $teachersDate = $this->getDataForObjectByName($teachersData,'create_at');

        $studentsData = $this->userModel->getData(['role_name'=>'student']);
        $studentsDate = $this->getDataForObjectByName($studentsData,'create_at');

        ksort($teachersDate);
        ksort($studentsDate);

        $teachersDate = array_values($teachersDate);
        $studentsDate = array_values($studentsDate);

        return view('main',['adminNumber'=>$adminNumber,'teacherNumber'=>$teacherNumber,'studentNumber'=>$studentNumber,'classesData'=>$classesData,'attendancesData'=>$attendancesData,'teachersCreateDate'=>$teachersDate,'studentsCreateDate'=>$studentsDate]);
    }

    public function  getDataForObjectByName($array,$objName){        
        $data = [];
        $pattern = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

        foreach ($array as $value) {
            $valueData = $value->$objName;

            if(preg_match($pattern, $valueData)){
                $valueData =  date("Y", strtotime($value->$objName));
            }

            if (isset($data[$valueData])) {
                $data[$valueData]++;
            } else {
                $data[$valueData] = 1;
            }
        }

        return $data;
    }
}