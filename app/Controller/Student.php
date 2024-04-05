<?php
namespace App\Controller;

use App\Model\ClassModel;
use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class Student{

    public Request $request;
    public Response $response;
    public Validation $validation;
    public ClassModel $classModel;
    public UserModel $userModel;

    public function __construct(Request $request,Response $response,Validation $validation,ClassModel $classModel,UserModel $userModel){
        $this->request = $request;
        $this->response = $response;
        $this->validation = $validation;
        $this->classModel = $classModel;
        $this->userModel = $userModel;
    }

    public function index(){
        $data = $this->request->getBody();
        $condition = ['role_name'=>'student'];
        $pattern = [];


        if(isset($data['search'])){
            $pattern['email'] = $data['search'];
        }

        $pageSum = $this->userModel->pages($condition,$pattern);
        $studentsData = $this->userModel->pagination($condition,$pattern,$data);

        return view('student/student',['pages'=>$pageSum,'studentsData'=>$studentsData,'data'=>$data]);
    }

    public function add(){
        $classesData = $this->classModel->getData([]);
        
        return view('student/student_create',['classesData'=>$classesData]);
    }

    public function edit(){
        $data = $this->request->getBody();
        $studentData = $this->userModel->getDataById($data['id']);

        if(!$studentData){
            setFlashMessage('error','Student dont exist');
            redirect('/student');
            exit;
        }
        
        return view('student/student_profile',['studentData'=>$studentData]);
    }

    public function editPassword(){
        $data = $this->request->getBody();
        $studentData = $this->userModel->getDataById($data['id']);

        if(!$studentData){
            setFlashMessage('error','Student dont exist');
            redirect('/student');
            exit;
        }

        return view('student/student_password',['studentData'=>$studentData]);
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

            $data['role_name'] = 'student';
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->userModel->insertData($data);

            setFlashMessage('success','Student created successfully');
            redirect('/student');
            exit;           
        }

        $classesData = $this->classModel->getData([]);
        return view('student/student_create',['validation'=>$this->validation,'classesData'=>$classesData]);
    }

    public function updateProfile(){
        $data = $this->request->getBody();
        $getRules = $this->userModel->profileUpdateRules();
        $userId = $data['userId'];
        $image = $data['image'];

        if($this->validation->validate($data,$getRules,$this->userModel,$userId)){
            unset($data['image']);
            unset($data['userId']);

            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $data['image'] = $image['name'];
            }

            $this->userModel->updateDataById($userId,$data);

            setFlashMessage('success','Student updated successfully');
            redirect('/student');
            exit;                    
        }

        $studentData = $this->userModel->getDataById($userId);
        $classesData = $this->classModel->getData();
        return view('student/student_profile',['validation'=>$this->validation,'studentData'=>$studentData,'classesData'=>$classesData]);
    }

    public function updatePassword(){
        $enteredPasswords = $this->request->getBody();
        $getRules = $this->userModel->passwordUpdateRules();
        $studentId = $enteredPasswords['userId'];
        $userPassword = $this->userModel->getData(['user_id'=>$studentId])[0]->password;

        if($this->validation->validate($enteredPasswords,$getRules,$this->userModel,$studentId)){ 

            if(password_verify($enteredPasswords['password'],$userPassword)){
                $hashedPassword = password_hash($enteredPasswords['renewpassword'], PASSWORD_DEFAULT);
                $this->userModel->updateDataById($studentId,['password'=>$hashedPassword]);

                setFlashMessage('success','Password updated successfully');
                redirect('/student');
                exit;      
            }
            $this->validation->addError('password','Incorrect password');
        }

        $studentData = $this->userModel->getDataById($studentId);

        return view('student/student_password',['validation'=>$this->validation,'studentData'=>$studentData]);
    }

    public function delete(){
        $data = $this->request->getBody();
        $checkingUser = $this->userModel->getData(['user_id'=>$data['id']]);

        if(!$checkingUser){
            setFlashMessage('error','Student doesnt exist');
            redirect('/student');
            exit;
        }

        if($data['id'] == getUserId()){
            setFlashMessage('error',"You can't delete yourself");
            redirect('/admin');
            exit;
        }

        $this->userModel->deleteData($data['id']);

        setFlashMessage('success','Student deleted successfully');
        redirect('/student');
        exit;
    }

}

?>