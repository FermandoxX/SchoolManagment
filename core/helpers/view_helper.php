<?php

function view($viewName, $params = []){    
    $view = app()->get(\Core\View::class);
    return $view->renderView($viewName,$params);
}

function setLayout($layout = 'main'){
    $view = app()->get(\Core\View::class);
    $view->setLayout($layout);
}

function redirect($url){
    $response = app()->get(\Core\Response::class);
    $response->redirect($url);
    exit;
}

