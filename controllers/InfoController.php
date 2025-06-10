<?php

namespace controllers;

use core\Controller;

class InfoController extends Controller
{
    public function actionDelivery() {
        return $this->render('info/delivery');
    }

    public function actionPayment() {
        return $this->render('info/payment');
    }

    public function actionReturn() {
        return $this->render('info/return');
    }
}
