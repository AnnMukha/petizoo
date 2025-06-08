<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Users;

class AdminController extends Controller
{
    public function beforeAction()
    {
        if (!Users::IsUserLogged() || $_SESSION['user']['email'] !== 'admin@petizoo.ua') {
            return $this->redirect('/');
        }
        return true;
    }

    public function actionDashboard()
    {
        return $this->render(); // views/admin/dashboard.php
    }

    public function actionProducts()
    {
        // У майбутньому: підвантаження товарів із БД
        return $this->render(); // views/admin/products.php
    }

    public function actionOrders()
    {
        // У майбутньому: підвантаження замовлень
        return $this->render(); // views/admin/orders.php
    }
}