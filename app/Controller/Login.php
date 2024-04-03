<?php 
namespace App\Controller;

use App\Model\UserModel;
use Core\Request;
use Core\Validation;
use Core\Response;

use Core\Session;

class Login{

   public Request $request;
   public Response $response;
   public Validation $validation;
   public Session $session;
   public UserModel $userModel;

   public function __construct(Request $request, Response $response, Validation $validation, Session $session, UserModel $userModel)
   {
      $this->request = $request;
      $this->response = $response;
      $this->validation = $validation;
      $this->session = $session;
      $this->userModel = $userModel;
   }

   public function index() {
      removeSession('userData');
      setLayout('auth');
      return view('login');
   }

   public function login(){

      $loginData = $this->request->getBody();
      $enteredEmail = $loginData['email'];
      $enteredPassword = $loginData['password'];
      $rules = $this->userModel->loginRules();

      if(!$this->validation->validate($loginData,$rules,$this->userModel)){
         setLayout('auth');
         return view('login',['validation'=>$this->validation]);
      }

      if (!$this->userModel->login($enteredEmail,$enteredPassword)) {
         setFlashMessage('error', 'Incorrect username or password');
         setLayout('auth');
         return view('login');
      }
      
      $userData = $this->userModel->getData(['email'=>$enteredEmail]);
      setSession('userData',$userData);
      setFlashMessage('success','Login success');
      redirect('/main');
      exit;
   
   }
}

?>