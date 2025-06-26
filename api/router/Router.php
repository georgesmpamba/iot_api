<?php
    //Classe pour gérer les routes de l'application
  header('Access-Control-Allow-Origin: *');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
header('Access-Control-Allow-Credentials: *');//Permet aux serveurs de se connecter sans erreur d'en-tête CORS  
  
class Router{
    private $routes = [];
    private $middleware = [];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function addMiddleware($middleware)
    {
        $this->middleware[] = $middleware;
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route['path']);

            $pattern = '#^' . $pattern . '$#';
            
            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove the full match
                $params = $matches;

                // Execute middleware in order
                $next = function () use ($route, $params) {
                    call_user_func_array($route['handler'], $params);
                };

                foreach (array_reverse($this->middleware) as $middleware) {
                    $next = function () use ($middleware, $next) {
                        $middleware($next);
                    };
                }
                $next();
                return;
            }
        }
        // Route not found
        header("HTTP/1.0 404 Not Found");
        echo json_encode(["datas"=>["error"=>"Ressource indisponible dans notre API",'key'=>0]]);
        exit;
    }
}
?>