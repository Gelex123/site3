<?php

namespace Library;

abstract class Router
{
    private static $map;
    public static $controller = null;
    public static $action = null;


    /**
     * @param $routesFile
     */
    public static function init($routesFile)
    {
        self::$map = require(CONF_DIR . $routesFile);
    }


    /**
     * @param $uri
     * @return bool
     */
    private static function isAdminUri($uri)
    {
        return strpos($uri, '/admin') === 0;
    }


    /**
     * @param Request $request
     * @throws \Exception
     */
    public static function match(Request $request)
    {
        // вытаскиваем УРЛ без параметров
        $uri = $request->getURI();

        if (self::isAdminUri($uri)){
            Controller::setAdminLayout();
        }

        // перебор элементов массива из routes.php для сопоставления с $uri
        foreach (self::$map as $route) {

            // заготовка для регулярки
            $regex = $route->pattern;

            // меняем там наши {param} на реальные виражения регулярки из соотв. массива
            foreach ($route->params as $k => $v) {
                $regex = str_replace('{' . $k . '}', '(' . $v . ')', $regex);
                // echo "$regex <br>";
            }

            // если нашли совпадение по регулярному выражению
            if (preg_match('@^' . $regex . '$@', $uri, $matches)) {

                // выталкиваем первы елемент - не нужен. Тогда остается либо пустой массив, либо список из значений параметров
                array_shift($matches);

                // если не пустой, то докидываем их в ГЕТ, как-будто они реально ГЕТ параметры
                if ($matches) {
                    $matches = array_combine(array_keys($route->params), $matches);
                    $request->mergeGet($matches);
                }

                // допиливаем названия контроллера и действия
                self::$controller = 'Controller\\' . $route->controller . 'Controller';
                self::$action = $route->action . 'Action';
                break;
            }
        }

        // если не опеределен контроллер то исключение
        if (is_null(self::$controller) || is_null(self::$action)) {
            throw new \Exception('Route not found: ' . $uri, 404);
        }
    }


    /**
     * @param $to
     */
    public static function redirect($to)
    {
        header('Location: ' . $to);
        die;
    }

    public static function getRouteUri($routeName, array $params = array())
    {

    }
}