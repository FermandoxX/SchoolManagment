<?php
namespace Core;

class Response {

    public $statusCode = 200;
    public $header = ['Content-Type' => 'text/html'];
    public $body = '';

    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
    }

    public function setHeader($name,$value){
        $this->header[$name] = $value;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function getBody(){
        return $this->body;
    }

    public function redirect($url){
        header('location: '.$url);
    }

    public function send(){
        http_response_code($this->statusCode);

        foreach($this->header as $name => $value){  
            header("$name:$value");
        }   

        echo $this->body;
    }

}