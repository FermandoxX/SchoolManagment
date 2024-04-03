<?php
namespace Core;

use Core\Request;
use Core\Response;

class Router{

   public Request $request;
   public Response $response;
   protected $routes = [];

   public function __construct(Request $request, Response $response)
   {
      $this->request = $request;
      $this->response = $response;
   }

   public function get($path, $callback, $middleware = [])
   {
      $this->routes['get'][$path]['callback'] = $callback;
      $this->routes['get'][$path]['middlewares'] = $middleware;
   }

   public function post($path, $callback, $middleware = [])
   {
      $this->routes['post'][$path]['callback'] = $callback;
      $this->routes['post'][$path]['middlewares'] = $middleware;
   }
    
   public function reslove()
   {
      $path = $this->request->getPath();
      $method = $this->request->getMethod();

      $callback = isset($this->routes[$method][$path]) ? $this->routes[$method][$path]['callback'] : false;
      
      if($callback === false){
         $this->response->statusCode = 404;
         setLayout('error');
         return view('404');
      }

      $middlewares = $this->routes[$method][$path] ? $this->routes[$method][$path]['middlewares'] : false;

      if ($middlewares) {
         foreach ($middlewares as $middleware) {
            $obj = app()->get($middleware);
            $obj->execute();
         }
      }

      $callback[0] = app()->get($callback[0]); 
      return call_user_func($callback);
   }

   public function run(){
      $body = $this->reslove();
      $this->response->setBody($body);
   }
}

?>