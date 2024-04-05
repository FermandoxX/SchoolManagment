<?php
namespace App\Controller\Teacher;

use App\Model\UserModel;
use Core\Request;
use Core\Validation;

class TeacherStudent{

    public Request $request;
    public Validation $validation;
    public UserModel $userModel;

    public function __construct(Request $request,Validation $validation,UserModel $userModel){
        $this->request = $request;
        $this->validation = $validation;
        $this->userModel = $userModel;
    }

    public function index(){
        $this->userModel->join = 'inner join subjects s on s.class_id = u.class_id';
        $data = $this->request->getBody();
        $condition = ['role_name'=>'student','teacher_id'=>getUserId()];
        $distinct = ['user_id', 'name', 'email', 'password', 'phone_number', 'role_name', 'address', 'image', 'surename'];
        $pattern = [];

        if(isset($data['search'])){
            $pattern['email'] = $data['search'];
        }

        $pageSum = $this->userModel->pages($condition,$pattern,null,$distinct);
        $studentsData = $this->userModel->pagination($condition,$pattern,$data,null,$distinct);

        return view('student/student',['pages'=>$pageSum,'studentsData'=>$studentsData,'data'=>$data]);
    }
}

?>