<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\News;
use core\Template;

class NewsController extends Controller
{
    // news/add
    public function actionAdd() {
        return $this->render();
    }
    // news/index
    public function actionIndex() {
        return $this->render('views/news/view.php');
    }
    public function actionView($params) {
        return $this->render();
    }
}