<?php
namespace controllers;

use core\Controller;
use models\Orders;

class AdminOrdersController extends Controller
{
    public function actionIndex()
    {
        $orders = \models\Orders::getAllWithDetails();  // ← явно виклик
        var_dump($orders); die();  // ← перевір чи є масив з даними
    }
}