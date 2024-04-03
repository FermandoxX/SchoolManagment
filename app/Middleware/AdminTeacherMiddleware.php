<?php

namespace App\Middleware;

class AdminTeacherMiddleware{

    public function execute() {
        if (isStudent()) {
            setLayout('error');
            echo view('403');
            die;
        }        
    }
}