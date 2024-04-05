<?php 

namespace App\Controller\Student;

use App\Model\UserModel;
use Core\Request;

class StudentTeacher {

    public Request $request;
    public UserModel $userModel;

    public function __construct(Request $request, UserModel $userModel)
    {
        $this->request = $request;
        $this->userModel = $userModel;
    }

    public function index(){
        
        $data = $this->request->getBody();
        $this->userModel->join = 'inner join subjects s on u.user_id = s.teacher_id';
        $condition = ['s.class_id'=>getUserData('class_id')];
        $pattern = [];

        if(isset($data['search'])){
            $pattern['email'] = $data['search'];
        }

        $pageSum = $this->userModel->pages($condition,$pattern);
        $teachersData = $this->userModel->pagination($condition,$pattern,$data);
        return view('teacher/teacher',['pages'=>$pageSum,'teachersData'=>$teachersData, 'data' => $data]);
    }

}

?>