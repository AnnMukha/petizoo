<?php

namespace controllers;

use core\Controller;
use models\Products;

class SiteController extends Controller
{
    public function actionIndex(){
        $popular = \models\Products::getTopPopular(10);
        $this->template->setParam('popular', $popular);
        return $this->render();
    }
    public function actionError($code){
        echo $code;
    }
}