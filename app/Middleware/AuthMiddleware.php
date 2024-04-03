<?php

namespace App\Middleware;

class AuthMiddleware{

    public function execute() {
        if (!session()->get('userData')) {
            redirect('/');
        }        
    }
}