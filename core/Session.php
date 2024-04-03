<?php

namespace Core;

class Session {//studjoje

    protected const FLASH_KEY = 'flashMessage';

    public function __construct(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();   
        }
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach($flashMessages as $key => &$flashMessage){
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function set($key,$value){
        $_SESSION[$key] = $value; 
    }

    public function get($key){
        return $_SESSION[$key] ?? false;
    }

    public function unset($key){
        unset($_SESSION[$key]);
    }

    public function setFlash($key,$message){
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key){
        $message = $_SESSION[self::FLASH_KEY][$key]['value'] ?? false; 

        if ($message) {
            $_SESSION[self::FLASH_KEY][$key]['remove'] = true;    
        }

        return $message;
    }

    public function __destruct(){
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach($flashMessages as $key => &$value){

            if($value['remove']){
               unset($flashMessages[$key]);
            }
            
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

}

?>