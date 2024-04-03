<?php

namespace Core;

use PDO;

class Validation {

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_SPECIFIC = 'specific';
    public const RULE_VALID = 'valid';
    public const RULE_PHONENUMBER = 'phone_number';
    public const RULE_IMAGE = 'image';
    public const RULE_GRADES = 'grades';
    public const RULE_DATE = 'date';
    // public const RULE_ISSET = 'isset';
    public array $errors = [];


      public function validate($data, $rule, $model = null,$id = null){
        foreach($rule as $attribute => $rules){
          $value = isset($data[$attribute]) ? $data[$attribute] : true;

          if($value === true){
            continue;
          }
          
          foreach($rules as $rule){
            $ruleName = $rule;
            if(!is_string($ruleName)){
              $ruleName = $rule[0];
            }   

            if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL) && $value != ''){
              $this->addErrorForRule($attribute,self::RULE_EMAIL);
            }

            if($ruleName === self::RULE_REQUIRED && (!$value || $value == '')){
              $this->addErrorForRule($attribute,self::RULE_REQUIRED); 
            }

            if($ruleName === self::RULE_MIN && strlen($value) < $rule['min'] && $value != ''){
              $this->addErrorForRule($attribute,self::RULE_MIN,$rule); 
            }

            if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
              $this->addErrorForRule($attribute,self::RULE_MAX,$rule); 
            }

            if($ruleName === self::RULE_UNIQUE && is_object($model)){
              $columnName = $attribute;
              $usersData = $model->getData([$columnName => $value]);
              $userData = $model->getDataById($id);

              if(isset($usersData[0]) && isset($userData->$columnName)){
                if($usersData[0]->$columnName == $userData->$columnName){
                   $usersData = [];
                }
              }

              if(!empty($usersData)){
                $this->addErrorForRule($attribute,self::RULE_UNIQUE,$rule);
              }
            }

            if($ruleName === self::RULE_MATCH && $value !== $data[$rule['match']]){
              $this->addErrorForRule($attribute,self::RULE_MATCH,$rule);
            }

            if($ruleName === self::RULE_SPECIFIC && !preg_match($rule['patter'],$value)){
              $this->addErrorForRule($attribute,self::RULE_SPECIFIC,$rule);
            }

            if($ruleName === self::RULE_PHONENUMBER && !preg_match("/^(068|069|067)\d{7}$/", $value)){
              $this->addErrorForRule($attribute,self::RULE_PHONENUMBER);
            }

            if($ruleName === self::RULE_IMAGE && $value['name'] != ""){
              
              $imgExt = strtolower(pathinfo($value['name'],PATHINFO_EXTENSION));
              $allowedExt = array("jpg","jpeg","png");
              
              if(!in_array($imgExt,$allowedExt)) {
                $this->addErrorForRule($attribute,self::RULE_IMAGE);
              }

            }

            if($ruleName == self::RULE_GRADES && ((int)$value < 4 || (int)$value > 10)){
              $this->addErrorForRule($attribute,self::RULE_GRADES);
            }

            if($ruleName === self::RULE_DATE && strtotime(date('m/d/Y')) < strtotime($value)){
              $this->addErrorForRule($attribute,self::RULE_DATE);
            }

          } 
        }
        return empty($this->errors);
      }

      private function addErrorForRule(string $attribute,string $rule,$params = []){     
        $message = $this->errormessage()[$rule] ?? '';

        foreach($params as $key => $value){

          if(isset($this->labels()[$value])){
            $value = $this->labels()[$value];
          }  

          $message = str_replace("{{$key}}",$value,$message);
        }

        $this->errors[$attribute][] = $message;
      }

      public function addError($attribute, $message){
        $this->errors[$attribute][] = $message;
      }

      public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
      }

      public function getFirstError($attribute){
        return $this->errors[$attribute][0] ?? false;
      }

      public function errorMessage(){
        return [ 
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => "This field must be valid ".$this->labels()[self::RULE_EMAIL]." address",
            self::RULE_MIN => 'Min length of the field must be {min}',
            self::RULE_MAX => 'Max length of the field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
            self::RULE_VALID => 'Record with this {field} already exists',
            self::RULE_PHONENUMBER => 'Invalid phone number',
            self::RULE_IMAGE => 'Unsupported file format. Please upload a photo in either .jpg, .jpeg, or .png format.',
            self::RULE_GRADES => 'Grades need to be between 4 and 10',
            self::RULE_DATE => 'Date cannot be higher than today'
        ];
      }
      
      public function labels(){
        return [
          'firstname' => 'firstname',
          'lastname' => 'lastname',
          'email' => 'email',
          'password' => 'password',
          'newpassword' => 'new password',
          'renewpassword' => 're-enter new password',
          'phone_number' => 'phone number', 
          'name'=>'name',
          'surename'=>'surename',
          'address'=>'address',
          'class_name'=>'class name'
        ];
      }

}