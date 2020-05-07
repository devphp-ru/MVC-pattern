<?php

namespace app\controllers;

use base\Controller;

class MainController extends Controller
{
    /**
     * метод, подключает главную страницу
     * @return false|string
     */
    public function actionIndex()
    {
        return $this->view->render('index',
            [
                'title' => 'Главная страница',
                'pageTitle' => 'Метод actionIndex',
            ]
        );
    }

    /**
     * метод, подключает тестовую страницу
     * @return false|string
     */
    public function actionTestPage()
    {
        return $this->view->render('test-page',
            [
                'title' => 'Вторая страница',
                'pageTitle' => 'Метод actionTestPage',
            ]
        );
    }
}
