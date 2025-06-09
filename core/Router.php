<?php

namespace core;

class Router
{
    protected $route;

    public function __construct($route)
    {
        $this->route = $route ?? '';
    }

    public function run()
    {
        $parts = explode('/', trim((string)$this->route, '/'));

        // Встановлюємо контролер та дію за замовчуванням
        if (empty($parts[0])) {
            $parts[0] = 'site';
            $parts[1] = 'index';
        } elseif (!isset($parts[1])) {
            $parts[1] = 'index';
        }

        \core\Core::get()->moduleName = $parts[0];
        \core\Core::get()->actionName = $parts[1];

        $controllerClass = 'controllers\\' . ucfirst($parts[0]) . 'Controller';
        $actionMethod = 'action' . ucfirst($parts[1]);

        if (class_exists($controllerClass)) {
            $controllerObject = new $controllerClass();
            \core\Core::get()->controllerObject = $controllerObject;

            $params = array_slice($parts, 2);

            // Підтримка передачі параметрів з урла (наприклад: /profile/order/6)
            if (!empty($params) && !isset($_GET['id'])) {
                $_GET['id'] = $params[0];
            }

            if (method_exists($controllerObject, $actionMethod)) {
                return $controllerObject->$actionMethod($params);
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
        if ($code == 404) {
            echo '<h1>404 Not Found</h1>';
        }
    }

    public function done()
    {
        // for compatibility
    }
}