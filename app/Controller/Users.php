<?php
namespace App\Controller;

use App\Model\UserModel;
use Core\Request;
use Core\Response;
use Core\Session;
use Core\Validation;

class Users {

    public UserModel $userModel;
    public Response $response;
    public Validation $validation;
    public Request $request;
    public Session $session;

    public function  __construct(UserModel $userModel,Response $response,Validation $validation,Request $request,Session $session){
      $this->userModel = $userModel;
      $this->response = $response;
      $this->validation = $validation;
      $this->request = $request;
      $this->session = $session;
    }

    public function index(){
        
        return view('user/user');
    }

    public function editPassword(){
        
        return view('user/user_password');
    }

    public function editProfile() {
        
        return view('user/user_profile');
    }

    public function updatePassword(){
        $enteredPasswords = $this->request->getBody();
        $getRules = $this->userModel->passwordUpdateRules();
        $userId = getUserId();
        $userPassword = getPassword();

        if($this->validation->validate($enteredPasswords,$getRules)){ 

            if(password_verify($enteredPasswords['password'],$userPassword)){
                $hashedPassword = password_hash($enteredPasswords['renewpassword'], PASSWORD_DEFAULT);
                $this->userModel->updateDataById($userId,['password'=>$hashedPassword]);

                $userData = $this->userModel->getData(['user_id' => getUserId()]);

                setSession('userData',$userData);
                setFlashMessage('success','Password updated successfully');
                redirect('/main');
                exit;      
            }
            $this->validation->addError('password','Incorrect password');
        }
        return view('user/user_password',['validation'=>$this->validation]);
 
    }
    
    public function updateProfile(){
        $enteredProfileData = $this->request->getBody();
        $getRules = $this->userModel->profileUpdateRules();
        $userId = getUserId();
        $image = $enteredProfileData['image'];

        if($this->validation->validate($enteredProfileData,$getRules,$this->userModel,$userId)){

            unset($enteredProfileData['image']);
            unset($enteredProfileData['userId']);

            if(isset($image['name']) && $image['name'] != ""){
                moveUploadedImage($image);
                $enteredProfileData['image'] = $image['name'];
            }

            $this->userModel->updateDataById($userId,$enteredProfileData);
            $userData = $this->userModel->getData(['user_id' => getUserId()]);
            setSession('userData',$userData);

            setFlashMessage('success','Profile updated successfully');
            redirect('/main');
            exit;                         
        }

        return view('user/user_profile',['validation'=>$this->validation]);
    }

}