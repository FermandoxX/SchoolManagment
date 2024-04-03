<?php 
namespace Core;

class View{

    public $layout = 'main';

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function renderView($view, $params = []){
        $layoutContent = $this->layoutContent($params);
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}',$viewContent,$layoutContent);
    }

    protected function layoutContent($params){
        $layout = $this->layout;
        ob_start();
        include_once "../public/view/layout/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view,$params = []){
        foreach($params as $key => $value){
            $$key = $value;
        }

        ob_start();
        include_once "../public/view/$view.php";
        return ob_get_clean();
    }

}

