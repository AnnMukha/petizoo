<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Products;
use core\DB;

class ProductsController extends Controller
{
    public function actionIndex()
    {
        $animal = $_GET['animal'] ?? 'all';
        $category = $_GET['category'] ?? 'all';
        $subcategory = $_GET['subcategory'] ?? 'all';

        $query = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if ($animal !== 'all') {
            $query .= " AND (is_for = :animal OR is_for = 'both')";
            $params['animal'] = $animal;
        }

        if ($subcategory !== 'all') {
            $query .= " AND subcategory_id = :subcategory";
            $params['subcategory'] = $subcategory;
        } elseif ($category !== 'all') {
            $query .= " AND subcategory_id IN (SELECT id FROM subcategories WHERE category_id = :category)";
            $params['category'] = $category;
        }

        $products = Core::get()->db->performQuery($query, $params);
        $categories = Core::get()->db->select('categories');
        $subcategories = Core::get()->db->select('subcategories');

        $this->template->setParams([
            'products' => $products,
            'animal' => $animal,
            'category' => $category,
            'subcategory' => $subcategory,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);

        return $this->render('products/index');
    }

    public function actionSale()
    {
        $products = Products::getDiscountedOrPopular();

        $this->template->setParams([
            'products' => $products,
            'animal' => 'all',
            'category' => 'all',
            'subcategory' => 'all'
        ]);

        return $this->render('products/sale');
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