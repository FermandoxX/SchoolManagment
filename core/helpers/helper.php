<?php

use Core\Model;

function app() {
    global $app;
    return $app;
}

function dd(...$args) {
    foreach ($args as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
    die();
}

function dp(...$args) {
    foreach ($args as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function checkLogin() {
    if (!isset($_SESSION['userId'])) {
        header("location:/");
        exit;
    }
}

function moveUploadedImage($image){
    $filePath ='../public/image/';
    $imgName = $image['name'];
    $image_upload_path = $filePath.$imgName;

    move_uploaded_file($image['tmp_name'],$image_upload_path);
}

function isAdmin(){
    return getRole() == 'admin' ? true : false;
}

function isTeacher(){
    return getRole() == 'teacher' ? true : false;
}

function isStudent(){
    return getRole() == 'student' ? true : false;
}