<?php
//Single point of entry, loads the controller and calls the function depending on the URL requested.
//Loads template file for that URL
namespace CSY2028;

class EntryPoint {
    private $routes;

    public function __construct(\CSY2028\Routes $routes) {
        $this->routes = $routes;
    }

    public function run() {
        $route = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
        $routes = $this->routes->getRoutes();
        $authentication = $this->routes->getAuth();
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($routes[$route]['loggedin']) && isset($routes[$route]['loggedin']) && !$authentication->isLoggedIn()) {
            header('location: /login');
        } else {
            $controller = $routes[$route][$method]['controller'];
            $functionName = $routes[$route][$method]['function'];
            $page = $controller->$functionName();
            $output = $this->loadTemplate('../templates/' . $page['template'], $page['variables']);
            $title = $page['title'];
            echo $this->loadTemplate('../templates/layout.html.php', $this->routes->getVarsForLayout($title, $output));
        }
    }

    function loadTemplate($fileName, $templateVars) {
        extract($templateVars);
        ob_start();
        require $fileName;
        $contents = ob_get_clean();
        return $contents;
    }
}