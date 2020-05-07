<?php

namespace base;

class Router
{
    use TNotFound;

    /**
     * метод, обрабатывает полученный url,
     * подключает нужный класс/метод,
     * если нет класса/метода, то 404 ошибка
     * @return mixed
     */
    public static function dispatch()
    {
        //получаем параметр GET news/, возвращаем news
        $url = self::getUrl();
        //вырезаем GET из url news?page=1 => news
        $url = self::removeString($url);
        //утанавливаем action, если нет, то по умолчание index
        $action = !empty($url) ? $url : 'index';
        //устанавливаем контроллер по умолчанию
        $controller = 'Main';
        //утанавливем namespace контроллера
        $className = 'app\\controllers\\' . $controller . 'Controller';
        //проверяем существование файла, если есть создаем объект класса
        $classObj = self::fileCheck($className);
        //приводим имя метода к нужному формату
        $method = 'action' . self::upperString($action);
        //вызываем метод класса, или ошибка 404
        return self::isMethod($classObj, $method);
    }

    /**
     * метод, возвращает полученный url
     * обрезаем крайний слеш
     * @return string
     */
    private static function getUrl()
    {
        return rtrim($_SERVER['QUERY_STRING'], '/');
    }

    /**
     * метод, принемает url и если есть
     * GET запрос, вырезает его из url
     * news?page=1 => news
     * если нет то возвращает url, без обработки
     * @param $url
     * @return false|string
     */
    private static function removeString($url)
    {
        if (preg_match("/.*=/", $url)) {
            return strstr($url, '&', true);
        }
        return $url;
    }

    /**
     * метод, проверяет существование файла класса,
     * если его нет ошбка 404,
     * если еть, создает объект класса
     * и возвращает его
     * @param $className - имя класса
     * @return mixed
     */
    private static function fileCheck($className)
    {
        $filePath = ROOT . '/' . str_replace('\\', '/', $className) . EXP;
        if (!file_exists($filePath)) {
            self::notFound();
        }
        return new $className;
    }

    /**
     * метод, проверяем существование метода в классе,
     * если его нет 404 ошибка,
     * если есть вызываем метод класса
     * @param $obj - объект класса
     * @param $method - вызываемый метод класса
     * @return mixed
     */
    private static function isMethod($obj, $method)
    {
        if (!method_exists($obj, $method)) {
            self::notFound();
        }
        return $obj->$method();
    }

    /**
     * метод, приводит имя метода/класса
     * в нужный формат
     * add-page => AddPage
     * @param $name
     * @return string
     */
    private static function upperString($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }
}
