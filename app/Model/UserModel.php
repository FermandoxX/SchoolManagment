<?php
namespace App\Model;

use Core\Model;


class UserModel extends Model{
    public $tableName = 'users';
    public $primaryKey = 'user_id';
    public $limit = 5;

    public function loginRules(){
      return [
        'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL],
        'password'=>[self::RULE_REQUIRED, [self::RULE_MIN,'min' => 8], [self::RULE_MAX,'max' => 24]]
      ];
    }

    public function createRules(){
      return [
        'name'=>[self::RULE_REQUIRED],
        'surename'=>[self::RULE_REQUIRED],
        'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL, [self::RULE_UNIQUE,'field'=>'email']],
        'password'=>[self::RULE_REQUIRED, [self::RULE_MIN,'min' => 8], [self::RULE_MAX,'max' => 24]],
        'address'=>[self::RULE_REQUIRED],
        'phone_number'=>[self::RULE_REQUIRED,self::RULE_PHONENUMBER],
        'image'=>[self::RULE_IMAGE],
        'class_id'=>[self::RULE_REQUIRED]
      ];
    }

    public function profileUpdateRules(){
      return [
        'name'=>[self::RULE_REQUIRED],
        'surename'=>[self::RULE_REQUIRED],
        'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL, [self::RULE_UNIQUE,'field'=>'email']],
        'address'=>[self::RULE_REQUIRED],
        'phone_number'=>[self::RULE_REQUIRED,self::RULE_PHONENUMBER],
        'image'=>[self::RULE_IMAGE]
      ];
    }

    public function passwordUpdateRules(){
      return [
        'password'=>[self::RULE_REQUIRED, [self::RULE_MIN,'min' => 8], [self::RULE_MAX,'max' => 24]],
        'newpassword'=>[self::RULE_REQUIRED, [self::RULE_MIN,'min' => 8], [self::RULE_MAX,'max' => 24]],
        'renewpassword'=>[self::RULE_REQUIRED, [self::RULE_MATCH,'match' => 'newpassword'], [self::RULE_MIN,'min' => 8], [self::RULE_MAX,'max' => 24]],
      ];
    }

    public function validPassword($columnName,$value,$enteredPassword){//For login
      $userPassword = $this->getData([$columnName=>$value]);

      if(!empty($userPassword)){
        $userPassword = $userPassword[0]->password;

        if(password_verify($enteredPassword,$userPassword)){
          return true;
        }
      }
      return false;
    }

    public function login($enteredEmail,$enteredPassword){
      $userData = $this->getData(['email' => $enteredEmail]);

      if (!$userData) {
        return false;
      }

      $userPassword = $userData[0]->password;

      if(!password_verify($enteredPassword,$userPassword)){
        return false;
      }

      return true;
    }

    public function pages($condition = [],$pattern = [],$distinct = []){
      $numberOfRows = count($this->getData($condition,$pattern,[],$distinct));
      $pages = ceil($numberOfRows/$this->limit);

      return $pages;
    }

    public function pagination($condition,$pattern,$requestData,$distinct = []){
      $offset = 0;

      if(isset($requestData['pageNr'])){
          $page = $requestData['pageNr'] - 1;
          $offset = $page * $this->limit;
      }

      $data = $this->getData($condition,$pattern,['limit'=>$this->limit,'offset'=>$offset],$distinct);
      return $data;
    }

    public function getUserByEmail($userEmail){
      $userData = $this->getData(['email' => $userEmail]);
      if ($userData) {
        return $userData[0];
      }
      return false;
    }
}