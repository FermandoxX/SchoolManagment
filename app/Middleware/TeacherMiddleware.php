<?php

namespace App\Middleware;

class TeacherMiddleware{

    public function execute() {
        if (!isTeacher()) {
            setLayout('error');
            echo view('403');
            die;
        }        
    }
}