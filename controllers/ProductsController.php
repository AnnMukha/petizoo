<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Products;

class ProductsController extends Controller
{
    public function actionIndex()
    {
        $animal = $_GET['animal'] ?? 'all';
        $category = $_GET['category'] ?? 'all';

        $conditions = [];

        if ($animal !== 'all') {
            $conditions['is_for'] = $animal;
        }

        if ($category !== 'all') {
            $conditions['subcategory_id'] = $category;
        }

        $products = \core\Core::get()->db->select('products', '*', $conditions);
        $subcategories = \core\Core::get()->db->select('subcategories');

        $this->template->setParams([
            'products' => $products,
            'animal' => $animal,
            'category' => $category,
            'categories' => $subcategories
        ]);

        return $this->render('products/index');
    }
    public function actionFavorite()
    {
        if (!\models\Users::IsUserLogged()) {
            return $this->redirect('/users/login');
        }

        $user = $_SESSION['user'];
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

        if ($productId <= 0) {
            return $this->redirect('/');
        }

        $existing = \core\Core::get()->db->select('favorites', '*', [
            'user_id' => $user['id'],
            'product_id' => $productId
        ]);

        if (empty($existing)) {
            \core\Core::get()->db->insert('favorites', [
                'user_id' => $user['id'],
                'product_id' => $productId
            ]);
        } else {
            \core\Core::get()->db->delete('favorites', [
                'user_id' => $user['id'],
                'product_id' => $productId
            ]);
        }

        return $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
    public function actionFavoriteajax()
    {
        if (!\models\Users::IsUserLogged()) {
            echo json_encode(['status' => 'unauthorized']);
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $productId = $_POST['product_id'] ?? null;

        if (!$productId) {
            echo json_encode(['status' => 'error']);
            exit;
        }

        $exists = \core\Core::get()->db->select('favorites', '*', [
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        if (empty($exists)) {
            \core\Core::get()->db->insert('favorites', [
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            echo json_encode(['status' => 'added']);
        } else {
            \core\Core::get()->db->delete('favorites', [
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            echo json_encode(['status' => 'removed']);
        }

        exit;
    }
}

