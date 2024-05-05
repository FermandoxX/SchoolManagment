<?php

namespace App\Middleware;

class StudentTeacherMiddleware{

    public function execute() {
        if (isAdmin()) {
            setLayout('error');
            echo view('403');
            die;
        }        
    }
}