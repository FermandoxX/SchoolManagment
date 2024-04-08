<?php

namespace App\Controller;

use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Validation;

class Admin{

    public UserModel $userModel;
    public Request $request;
    public Response $response;
    public Validation $validation;

    public function __construct(UserModel $userModel,Request $request,Response $response,Validation $validation)
    {
        $this->userModel = $userModel;
        $this->request = $request;
        $this->response = $response;
        $this->validation = $validation;
    }

    public function index(){
        $data = $this->request->getBody();
        $condition = ['role_name'=>'admin'];
        $pattern = [];

        if(isset($data['search'])){
            $pattern['email'] = $data['search'];
        }

        $pageSum = $this->userModel->pages($condition,$pattern);
        $userData = $this->userModel->pagination($condition,$pattern,$data);
        return view('admin/admin',['pages'=>$pageSum,'usersData'=>$userData, 'data' => $data]);
    }

    public function add(){
        return view('admin/admin_create');
    }

    public function create(){
        $createUserData = $this->request->getBody();
        $rules = $this->userModel->createRules();
        $image = $createUserData['image'];

        if($this->validation->validate($createUserData,$rules,$this->userModel)){
            unset($createUserData['image']);
            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $createUserData['image'] = $image['name'];
            }

            $createUserData['role_name'] = 'admin';
            $createUserData['password'] = password_hash($createUserData['password'], PASSWORD_DEFAULT);
            
            $this->userModel->insertData($createUserData);
            setFlashMessage('success','Admin created successfully');
            redirect('/admin');
            exit;
        }
        return view('admin/admin_create',['validation'=>$this->validation]);
    }

    public function edit(){
        $data = $this->request->getBody();
        $userData = $this->userModel->getDataById($data['id']);

        if($data['id'] == getUserId() || !$userData){
            setFlashMessage('error','Admin dont exist');
            redirect('/admin');
            exit;
        }

        return view('admin/admin_profile',['userData'=>$userData]);
    }

    public function editPassword(){
        
        $data = $this->request->getBody();
        $userData = $this->userModel->getDataById($data['id']);

        if($data['id'] == getUserId() || !$userData){
            setFlashMessage('error','Admin dont exist');
            redirect('/admin');
            exit;
        }

        return view('admin/admin_password',['userData'=>$userData]);
    }



    public function updateProfile(){
        $data = $this->request->getBody();
        $rules = $this->userModel->profileUpdateRules();
        $adminId = $this->request->getBody()['userId'];
        $image = $data['image'];

        if($this->validation->validate($data,$rules,$this->userModel,$adminId)){
            unset($data['image']);
            unset($data['userId']);

            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $data['image'] = $image['name'];
            }

            $this->userModel->updateDataById($adminId,$data);
            setFlashMessage('success','Admin updated successfully');
            redirect('/admin');
            exit;                    
        }

        $adminData = $this->userModel->getDataById($adminId);
        return view('admin/admin_profile',['validation'=>$this->validation,'userData'=>$adminData]);

    }

    public function updatePassword(){
        $data = $this->request->getBody();
        $rules = $this->userModel->passwordUpdateRules();
        $userId = $data['userId'];
        $userPassword = $this->userModel->getData(['user_id'=>$userId])[0]->password;

        if($this->validation->validate($data,$rules,$this->userModel,$userId)){ 

            if(password_verify($data['password'],$userPassword)){
                $hashedPassword = password_hash($data['renewpassword'], PASSWORD_DEFAULT);
                $this->userModel->updateDataById($userId,['password'=>$hashedPassword]);

                setFlashMessage('success','Password updated successfully');
                redirect('/admin');
                exit;      
            }
            $this->validation->addError('password','Incorrect password');
        }

        $studentData = $this->userModel->getDataById($data['userId']);
        return view('admin/admin_password',['validation'=>$this->validation,'userData'=>$studentData]);
    }

    public function delete(){
        $data = $this->request->getBody();
        $checkingUser = $this->userModel->getData(['user_id'=>$data['id']]);

        if(!$checkingUser){
            setFlashMessage('error','Admin doesnt exist');
            redirect('/admin');
            exit;
        }

        if($data['id'] == getUserId()){
            setFlashMessage('error',"You can't delete yourself");
            redirect('/admin');
            exit;
        }

        $this->userModel->deleteData($data['id']);
        setFlashMessage('success','Admin deleted successfully');
        redirect('/admin');
        exit;
    }

}


?>