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

        $products = Core::get()->db->select('products', '*', $conditions);
        $subcategories = Core::get()->db->select('subcategories');

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

        $existing = Core::get()->db->select('favorites', '*', [
            'user_id' => $user['id'],
            'product_id' => $productId
        ]);

        if (empty($existing)) {
            Core::get()->db->insert('favorites', [
                'user_id' => $user['id'],
                'product_id' => $productId
            ]);
        } else {
            Core::get()->db->delete('favorites', [
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
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

        if ($productId <= 0) {
            echo json_encode(['status' => 'error']);
            exit;
        }

        $exists = Core::get()->db->select('favorites', '*', [
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        if (empty($exists)) {
            Core::get()->db->insert('favorites', [
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            echo json_encode(['status' => 'added']);
        } else {
            Core::get()->db->delete('favorites', [
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            echo json_encode(['status' => 'removed']);
        }

        exit;
    }

    public function actionView($params)
    {
        $productId = isset($params[0]) ? (int)$params[0] : 0;

        if ($productId <= 0) {
            return $this->redirect('/products');
        }

        $result = Core::get()->db->select('products', '*', [
            'id' => $productId
        ]);

        $product = !empty($result) ? $result[0] : null;

        if (!$product) {
            http_response_code(404);
            return $this->render('site/404');
        }

        $this->template->setParams([
            'product' => $product
        ]);

        return $this->render('products/view');
    }
}