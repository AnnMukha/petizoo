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

        $controllerClass = '';
        $actionMethod = '';
        $params = [];

        $controllerPrefix = ucfirst($parts[0]);
        $controllerSuffix = ucfirst($parts[1] ?? 'index');

        // Спроба знайти вкладений контролер
        if (isset($parts[1]) && class_exists('controllers\\' . $controllerPrefix . $controllerSuffix . 'Controller')) {
            $controllerClass = 'controllers\\' . $controllerPrefix . $controllerSuffix . 'Controller';
            $actionMethod = 'action' . ucfirst($parts[2] ?? 'index');
            $params = array_slice($parts, 3);
        } else {
            // Стандартний контролер
            $controllerClass = 'controllers\\' . $controllerPrefix . 'Controller';
            $actionMethod = 'action' . ucfirst($parts[1]);
            $params = array_slice($parts, 2);
        }

        if (class_exists($controllerClass)) {
            $controllerObject = new $controllerClass();
            \core\Core::get()->controllerObject = $controllerObject;

            if (!empty($params) && !isset($_GET['id'])) {
                $_GET['id'] = $params[0];
            }

            if (method_exists($controllerObject, $actionMethod)) {
                return $controllerObject->$actionMethod($params);
            }
        }

        $this->error(404);
    }

    public function error($code)
    {
        http_response_code($code);
        if ($code === 404) {
            if (class_exists('controllers\\ErrorController')) {
                $controller = new \controllers\ErrorController();
                $controller->actionNotFound();
            } else {
                echo '<h1>404 - Сторінка не знайдена</h1>';
            }
        } else {
            echo "<h1>Помилка {$code}</h1>";
        }

        exit;
    }

    public function done()
    {
        // for compatibility
    }
}