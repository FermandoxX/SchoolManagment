<?php 

namespace App\Controller;

use App\Model\SubjectModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class Teacher {

    public Request $request;
    public Response $response;
    public Validation $validation;
    public UserModel $userModel;
    public SubjectModel $subjectModel;

    public function __construct(Request $request, Response $response, Validation $validation, UserModel $userModel, SubjectModel $subjectModel)
    {
        $this->request = $request;
        $this->response = $response;
        $this->validation = $validation;
        $this->userModel = $userModel;
        $this->subjectModel = $subjectModel;
    }

    public function index(){
        
        $data = $this->request->getBody();
        $condition = ['role_name'=>'teacher'];
        $rowPerPage = 5;
        $offset = 0;
        $pattern = [];
        $query = null;

        if(isset($data['search'])){
            $pattern['email'] = $data['search'];
        }

        if(isStudent()){
            $query = 'inner join subjects s on u.user_id = s.teacher_id';
            $condition = ['s.class_id'=>getUserData('class_id')];
        }

        $pageSum = $this->userModel->pages($condition,$rowPerPage,$pattern,$query);
        $teachersData = $this->userModel->pagination($condition,$rowPerPage,$offset,$pattern,$data,$query);
        return view('teacher/teacher',['pages'=>$pageSum,'teachersData'=>$teachersData, 'data' => $data]);
    }

    public function add(){
        
        return view('teacher/teacher_create');
    }

    public function editProfile(){
        
        $data = $this->request->getBody();
        $teacherData = $this->userModel->getDataById($data['id']);

        if(!$teacherData){
            setFlashMessage('error','Teacher dont exist');
            redirect('/teacher');
            exit;
        }

        return view('teacher/teacher_profile',['teacherData'=>$teacherData]);
    }

    public function editPassword(){
        
        $data = $this->request->getBody();
        $teacherData = $this->userModel->getDataById($data['id']);

        if(!$teacherData){
            setFlashMessage('error','Teacher dont exist');
            redirect('/teacher');
            exit;
        }

        return view('teacher/teacher_password',['teacherData'=>$teacherData]);
    }

    public function create(){
        $data = $this->request->getBody();
        $getRules = $this->userModel->createRules();
        $image = $data['image'];

        if($this->validation->validate($data,$getRules,$this->userModel)){
            unset($data['image']);

            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $data['image'] = $image['name'];
            }
            
            $data['role_name'] = 'teacher';
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            
            $this->userModel->insertData($data);
            setFlashMessage('success','Teacher created successful');
            redirect('/teacher');
            exit;
        }
        return view('teacher/teacher_create',['validation'=>$this->validation]);
    }

    public function updateProfile(){
        $teacherData = $this->request->getBody();
        $getRules = $this->userModel->createRules();
        $image = $teacherData['image'];
        $teacherId = $teacherData['userId'];

        if($this->validation->validate($teacherData,$getRules,$this->userModel,$teacherId)){
            unset($teacherData['image']);
            unset($teacherData['userId']);

            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $teacherData['image'] = $image['name'];
            }
            
            $teacherData['role_name'] = 'teacher';
            $teacherData['password'] = password_hash($teacherData['password'], PASSWORD_DEFAULT);
            
            $this->userModel->updateDataById($teacherId,$teacherData);
            setFlashMessage('success','Teacher created successful');
            redirect('/teacher');
            exit;
        }

        $teacherData = $this->userModel->getDataById($teacherId);
        
        return view('teacher/teacher_profile',['validation'=>$this->validation,'teacherData'=>$teacherData]);
    }

    public function updatePassword(){
        $enteredPasswords = $this->request->getBody();
        $getRules = $this->userModel->passwordUpdateRules();
        $userId = $enteredPasswords['userId'];
        $userPassword = $this->userModel->getData(['user_id'=>$userId])[0]->password;
        $teacherData = $this->userModel->getDataById($enteredPasswords['userId']);

        if($this->validation->validate($enteredPasswords,$getRules,$this->userModel,$userId)){ 

            if(password_verify($enteredPasswords['password'],$userPassword)){
                $hashedPassword = password_hash($enteredPasswords['renewpassword'], PASSWORD_DEFAULT);
                $this->userModel->updateDataById($userId,['password'=>$hashedPassword]);

                setFlashMessage('success','Password updated successfully');
                redirect('/teacher');
                exit;      
            }
            $this->validation->addError('password','Incorrect password');
        }
        return view('teacher/teacher_password',['validation'=>$this->validation,'teacherData'=>$teacherData]);
    }

    public function delete(){
        $data = $this->request->getBody();
        $checkingTeacher = $this->userModel->getData(['user_id'=>$data['id']]);

        if(!$checkingTeacher){
            setFlashMessage('error','Teacher doesnt exist');
            redirect('/teacher');
            exit;
        }

        if($data['id'] == getUserId()){
            setFlashMessage('error',"You can't delete yourself");
            redirect('/admin');
            exit;
        }

        $this->subjectModel->updateData(['teacher_id'=>$data['id']],['teacher_id'=>null]);
        $this->userModel->deleteData($data['id']);

        setFlashMessage('success','Teacher deleted successfully');
        redirect('/teacher');
        exit;
    }

}

?>