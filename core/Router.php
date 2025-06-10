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

        // --- підтримка вкладених контролерів (наприклад: AdminOrdersController) ---
        $controllerClass = '';
        $actionMethod = '';
        $params = [];

        $controllerPrefix = ucfirst($parts[0]);
        $controllerSuffix = ucfirst($parts[1] ?? 'index');

        // Спроба знайти клас типу AdminOrdersController
        if (isset($parts[1]) && class_exists('controllers\\' . $controllerPrefix . $controllerSuffix . 'Controller')) {
            $controllerClass = 'controllers\\' . $controllerPrefix . $controllerSuffix . 'Controller';
            $actionMethod = 'action' . ucfirst($parts[2] ?? 'index');
            $params = array_slice($parts, 3);
        } else {
            // Звичайний контролер типу SiteController
            $controllerClass = 'controllers\\' . $controllerPrefix . 'Controller';
            $actionMethod = 'action' . ucfirst($parts[1]);
            $params = array_slice($parts, 2);
        }

        if (class_exists($controllerClass)) {
            $controllerObject = new $controllerClass();
            \core\Core::get()->controllerObject = $controllerObject;

            // Додаткова підтримка для GET-параметра id
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