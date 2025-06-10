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
        $subcategory = $_GET['subcategory'] ?? 'all';
        $search = trim($_GET['search'] ?? '');

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

        if (!empty($search)) {
            $query .= " AND name LIKE :search";
            $params['search'] = '%' . $search . '%';
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
            'search' => $search
        ]);

        return $this->render('products/index');
    }

    public function actionSale()
    {
        $products = Products::findByCondition(['is_discounted' => 1]);

        $this->template->setParam('products', $products);
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

        $result = Core::get()->db->select('products', '*', ['id' => $productId]);
        $product = !empty($result) ? $result[0] : null;

        if (!$product) {
            http_response_code(404);
            return $this->render('site/404');
        }

        $comments = Core::get()->db->performQuery("SELECT c.*, u.login FROM comments c JOIN users u ON c.user_id = u.id WHERE c.product_id = :pid ORDER BY c.created_at DESC", ['pid' => $productId]);

        $this->template->setParams([
            'product' => $product,
            'comments' => $comments
        ]);

        return $this->render('products/view');
    }

    public function actionAddcomment()
    {
        if (!\models\Users::IsUserLogged()) {
            $_SESSION['error'] = 'Увійдіть, щоб залишити коментар';
            return $this->redirect('/users/login');
        }

        $user = \models\Users::GetCurrentAuthenticatedUser();
        $productId = $_POST['product_id'] ?? null;
        $content = trim($_POST['content'] ?? '');

        if ($productId && !empty($content)) {
            Core::get()->db->insert('comments', [
                'product_id' => $productId,
                'user_id' => $user['id'],
                'comment' => $content
            ]);
        }

        return $this->redirect("/products/view/{$productId}");
    }

    public function actionUpdatecomment()
    {
        if (!\models\Users::IsUserLogged()) {
            $_SESSION['error'] = 'Увійдіть, щоб редагувати коментар';
            return $this->redirect('/users/login');
        }

        $user = \models\Users::GetCurrentAuthenticatedUser();
        $commentId = $_POST['comment_id'] ?? null;
        $productId = $_POST['product_id'] ?? null;
        $newContent = trim($_POST['content'] ?? '');

        if (!$commentId || !$productId || empty($newContent)) {
            $_SESSION['error'] = 'Неправильні дані для оновлення';
            return $this->redirect("/products/view/{$productId}");
        }

        $comment = Core::get()->db->select('comments', '*', ['id' => $commentId]);

        if (empty($comment)) {
            $_SESSION['error'] = 'Коментар не знайдено';
            return $this->redirect("/products/view/{$productId}");
        }

        if ((int)$comment[0]['user_id'] === (int)$user['id']) {
            Core::get()->db->update('comments', [
                'comment' => $newContent
            ], ['id' => $commentId]);
            $_SESSION['success'] = 'Коментар оновлено';
        } else {
            $_SESSION['error'] = 'Це не ваш коментар';
        }

        return $this->redirect("/products/view/{$productId}");
    }
}