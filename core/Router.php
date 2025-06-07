<?php

namespace core;

class Router
{
    protected $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function run()
    {
        $parts = explode('/', trim($this->route, '/'));

        if (empty($parts[0])) {
            $parts[0] = 'site';
            $parts[1] = 'index';
        } elseif (!isset($parts[1])) {
            $parts[1] = 'index';
        }

        \core\Core::get()->moduleName = $parts[0];
        \core\Core::get()->actionName = $parts[1];

        $controller = 'controllers\\' . ucfirst($parts[0]) . 'Controller';
        $method = 'action' . ucfirst($parts[1]);

        if (class_exists($controller)) {
            $controllerObject = new $controller();
            \core\Core::get()->controllerObject = $controllerObject;

            $params = array_slice($parts, 2);

            // ✅ Підтримка id з URL: /profile/order/6
            if (!empty($params) && !isset($_GET['id'])) {
                $_GET['id'] = $params[0];
            }

            if (method_exists($controllerObject, $method)) {
                return $controllerObject->$method($params);
            } else {
                $this->error(404);
            }
        } else {
            $this->error(404);
        }
    }

    public function error($code)
    {
        http_response_code($code);
        switch ($code) {
            case '404':
                echo '<h1>404 Not Found</h1>';
                break;
        }
    }

    public function done()
    {
        // Placeholder
    }
}