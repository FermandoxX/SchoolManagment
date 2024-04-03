<?php
function session(){
    return app()->get(Core\Session::class);
}

function response(){
    return app()->get(Core\Response::class);
}

function removeSession($key){
   session()->unset($key);
}

function setSession($key,$value){
    session()->set($key,$value);
}

function getSession($key){
    return session()->get($key);
}

function getFlashMessage($key){
    return session()->getFlash($key);
}

function setFlashMessage($key,$message){
   session()->setFlash($key,$message);
}

function setUserLoggedIn($authData){
    session()->set('user' , $authData);
}

function getUserData($fieldName){
    return session()->get('userData')[0]->$fieldName;
}

function getUserId(){
    return session()->get('userData')[0]->user_id;
}

function getName(){
    return session()->get('userData')[0]->name;
}

function getSurename(){
    return session()->get('userData')[0]->surename;
}

function getEmail(){
    return session()->get('userData')[0]->email;
}

function getPassword(){
    return session()->get('userData')[0]->password;
}

function getAddress(){
    return session()->get('userData')[0]->address;
}

function getPhoneNumber(){
    return session()->get('userData')[0]->phone_number;
}

function getRole(){
    return session()->get('userData')[0]->role_name;
}

function getImage(){
    return session()->get('userData')[0]->image;
}