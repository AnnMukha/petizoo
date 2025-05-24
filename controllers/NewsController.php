<?php

namespace controllers;

use core\Template;

class NewsController
{
    // news/add
    public function actionAdd() {
        $template = new Template('views/news/add.php');
        return [
            'Content' => $template->getHTML(),
            'Title' => 'Додавання новини',
        ];
    }
    // news/index
    public function actionIndex() {
        $template = new Template('views/news/index.php');
        return [
            'Content' => $template->getHTML(),
            'Title' => 'Список новин',
        ];
    }
    public function actionView($params) {
        return [
            'Content' => 'News View',
            'Title' => 'Перегляд новини',
        ];
    }
}