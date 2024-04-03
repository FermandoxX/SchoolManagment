<?php

namespace App\Middleware;

class AdminMiddleware{

    public function execute() {
        if (!isAdmin()) {
            setLayout('error');
            echo view('403');
            die;
        }        
    }
}