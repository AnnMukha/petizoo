<?php

namespace controllers;

use core\Controller;
use core\Core;

class FavoritesController extends Controller
{
    public function actionAdd($params)
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Увійдіть, щоб додати в улюблені';
            return $this->redirect('/products');
        }

        $productId = (int)$params[0];
        $userId = $_SESSION['user']['id'];

        $exists = Core::get()->db->select('favorites', '*', [
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        if (empty($exists)) {
            Core::get()->db->insert('favorites', [
                'user_id' => $userId,
                'product_id' => $productId
            ]);
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionRemove($params)
    {
        if (!isset($_SESSION['user']))
            return $this->redirect('/products');

        Core::get()->db->delete('favorites', [
            'user_id' => $_SESSION['user']['id'],
            'product_id' => (int)$params[0]
        ]);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}