<?php

namespace base;

abstract class Controller
{
    protected $view;
    protected $default = 'default';

    public function __construct()
    {
        $this->view = new View($this->default);
    }

    abstract public function actionIndex();
}
