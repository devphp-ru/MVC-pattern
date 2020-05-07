<?php

namespace base;

class View
{
    use TNotFound;

    private $default;

    /**
     * устанавливаем основной шаблон
     * View constructor.
     * @param $default
     */
    public function __construct($default)
    {
        $this->default = $this->setTemplate($default);
    }

    /**
     * метод, подключаем шабоны
     * и передает в них данные
     * @param $tmpl - шаблон страницы
     * @param array $data - массив данных
     * @return false|string
     */
    public function render($tmpl, array $data)
    {
        ob_start();
        if (is_array($data)) { extract($data); }
        $default = $this->getTemplate();
        require $default;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * метод, проверяет файл шаблона
     * если его нет, 404 ошибка
     * если есть устанавливаем его
     * @param $default
     * @return string
     */
    private function setTemplate($default)
    {
        $filePath = LAYOUT . '/' . $default . EXP;
        if (!file_exists($filePath)) {
           self::notFound();
        }
        return $filePath;
    }

    /**
     * метод, возвращает установленный шаблон
     * @return string
     */
    private function getTemplate()
    {
        return $this->default;
    }
}
