<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Users;

class CartController extends Controller
{
    public function actionAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;

            if (!$productId || !is_numeric($productId)) {
                return $this->redirect('/products');
            }

            $user = \models\Users::GetCurrentAuthenticatedUser();

            if ($user !== null) {
                $existing = \core\Core::get()->db->select('cart_items', '*', [
                    'user_id' => $user['id'],
                    'product_id' => $productId
                ]);

                if (!empty($existing)) {
                    \core\Core::get()->db->update('cart_items', [
                        'quantity' => $existing[0]['quantity'] + 1
                    ], ['id' => $existing[0]['id']]);
                } else {
                    \core\Core::get()->db->insert('cart_items', [
                        'user_id' => $user['id'],
                        'product_id' => $productId,
                        'quantity' => 1
                    ]);
                }

                $count = \core\Core::get()->db->performQuery("
                SELECT SUM(quantity) as total 
                FROM cart_items 
                WHERE user_id = :user_id
            ", ['user_id' => $user['id']]);

                $_SESSION['cart_count'] = $count[0]['total'] ?? 0;

            } else {
                // Для неавторизованих — зберігаємо в сесії
                if (!isset($_SESSION['cart']))
                    $_SESSION['cart'] = [];

                $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
                $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
            }

            return $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }

        return $this->redirect('/products');
    }

    public function actionRemove($params)
    {
        $productId = $params[0] ?? null;
        $user = Users::GetCurrentAuthenticatedUser();

        if ($user !== null) {
            Core::get()->db->delete('cart_items', [
                'user_id' => $user['id'],
                'product_id' => $productId
            ]);
            $count = Core::get()->db->performQuery("SELECT SUM(quantity) as total FROM cart_items WHERE user_id = :user_id", [
                'user_id' => $user['id']
            ]);
            $_SESSION['cart_count'] = $count[0]['total'] ?? 0;
        } else {
            unset($_SESSION['cart'][$productId]);
            $_SESSION['cart_count'] = array_sum($_SESSION['cart'] ?? []);
        }

        return $this->redirect('/cart/index');
    }

    public function actionIncrease($params)
    {
        $productId = $params[0] ?? null;
        $user = Users::GetCurrentAuthenticatedUser();

        if ($user !== null) {
            $cartItem = Core::get()->db->select('cart_items', '*', [
                'user_id' => $user['id'],
                'product_id' => $productId
            ])[0] ?? null;
            $product = Core::get()->db->select('products', '*', ['id' => $productId])[0] ?? null;

            if ($cartItem && $product && $cartItem['quantity'] < $product['stock']) {
                Core::get()->db->update('cart_items', [
                    'quantity' => $cartItem['quantity'] + 1
                ], ['id' => $cartItem['id']]);
            }
            $count = Core::get()->db->performQuery("SELECT SUM(quantity) as total FROM cart_items WHERE user_id = :user_id", [
                'user_id' => $user['id']
            ]);
            $_SESSION['cart_count'] = $count[0]['total'] ?? 0;

        } else {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]++;
            }
            $_SESSION['cart_count'] = array_sum($_SESSION['cart'] ?? []);
        }

        return $this->redirect('/cart/index');
    }

    public function actionDecrease($params)
    {
        $productId = $params[0] ?? null;
        $user = Users::GetCurrentAuthenticatedUser();

        if ($user !== null) {
            $cartItem = Core::get()->db->select('cart_items', '*', [
                'user_id' => $user['id'],
                'product_id' => $productId
            ])[0] ?? null;

            if ($cartItem && $cartItem['quantity'] > 1) {
                Core::get()->db->update('cart_items', [
                    'quantity' => $cartItem['quantity'] - 1
                ], ['id' => $cartItem['id']]);
            }
            $count = Core::get()->db->performQuery("SELECT SUM(quantity) as total FROM cart_items WHERE user_id = :user_id", [
                'user_id' => $user['id']
            ]);
            $_SESSION['cart_count'] = $count[0]['total'] ?? 0;

        } else {
            if (!empty($_SESSION['cart'][$productId]) && $_SESSION['cart'][$productId] > 1) {
                $_SESSION['cart'][$productId]--;
            }
            $_SESSION['cart_count'] = array_sum($_SESSION['cart'] ?? []);
        }

        return $this->redirect('/cart/index');
    }

    public function actionIndex()
    {
        $user = Users::GetCurrentAuthenticatedUser();
        $cartItems = [];

        if ($user !== null) {
            $cartItems = Core::get()->db->performQuery("SELECT ci.*, p.name, p.price, p.image, p.stock FROM cart_items ci JOIN products p ON p.id = ci.product_id WHERE ci.user_id = :user_id", [
                'user_id' => $user['id']
            ]);
        } elseif (!empty($_SESSION['cart'])) {
            $ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = Core::get()->db->pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $productsData = $stmt->fetchAll();

            foreach ($productsData as $product) {
                $cartItems[] = [
                    'product_id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'stock' => $product['stock'],
                    'quantity' => $_SESSION['cart'][$product['id']]
                ];
            }
        }

        $this->template->setParams([
            'items' => $cartItems,
            'isGuest' => ($user === null)
        ]);
        return $this->render('cart/index');
    }

    public function actionAjaxAdd($params)
    {
        $productId = $params[0] ?? null;
        if ($productId === null) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
            exit;
        }

        $user = Users::GetCurrentAuthenticatedUser();

        if ($user !== null) {
            $existing = Core::get()->db->select('cart_items', '*', [
                'user_id' => $user['id'],
                'product_id' => $productId
            ]);

            if (!empty($existing)) {
                Core::get()->db->update('cart_items', [
                    'quantity' => $existing[0]['quantity'] + 1
                ], ['id' => $existing[0]['id']]);
            } else {
                Core::get()->db->insert('cart_items', [
                    'user_id' => $user['id'],
                    'product_id' => $productId,
                    'quantity' => 1
                ]);
            }

            $count = Core::get()->db->performQuery("SELECT SUM(quantity) as total FROM cart_items WHERE user_id = :user_id", [
                'user_id' => $user['id']
            ]);
            $_SESSION['cart_count'] = $count[0]['total'] ?? 0;

        } else {
            if (!isset($_SESSION['cart']))
                $_SESSION['cart'] = [];

            $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + 1;
            $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
        }

        echo json_encode([
            'status' => 'success',
            'count' => $_SESSION['cart_count'] ?? 0
        ]);
        exit;
    }
    public function actionUpdate()
    {
        $user = \models\Users::GetCurrentAuthenticatedUser();

        // 🔴 Обробка видалення товару
        if (isset($_POST['remove'])) {
            $productId = $_POST['remove'];

            if ($user !== null) {
                Core::get()->db->delete('cart_items', [
                    'user_id' => $user['id'],
                    'product_id' => $productId
                ]);
            } else {
                unset($_SESSION['cart'][$productId]);
            }

            // Оновлення лічильника
            $_SESSION['cart_count'] = $user !== null
                ? (Core::get()->db->performQuery(
                    "SELECT SUM(quantity) as total FROM cart_items WHERE user_id = :user_id",
                    ['user_id' => $user['id']]
                )[0]['total'] ?? 0)
                : array_sum($_SESSION['cart'] ?? []);

            return $this->redirect('/cart/index');
        }

        // 🔵 Оновлення кількості товарів
        if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $productId => $newQuantity) {
                $product = Core::get()->db->select('products', '*', ['id' => $productId])[0] ?? null;

                if (!$product) {
                    $this->addErrorMessage("Товар з ID {$productId} не знайдено.");
                    continue;
                }

                if (!is_numeric($newQuantity) || $newQuantity < 1) {
                    $this->addErrorMessage("Некоректна кількість для '{$product['name']}'.");
                    continue;
                }

                if ($newQuantity > $product['stock']) {
                    $this->addErrorMessage("На складі лише {$product['stock']} шт. товару '{$product['name']}'");
                    continue;
                }

                if ($user !== null) {
                    Core::get()->db->update('cart_items', [
                        'quantity' => $newQuantity
                    ], [
                        'user_id' => $user['id'],
                        'product_id' => $productId
                    ]);
                } else {
                    if (isset($_SESSION['cart'][$productId]))
                        $_SESSION['cart'][$productId] = $newQuantity;
                }
            }
        }

        // 🔄 Переобчислення лічильника
        $_SESSION['cart_count'] = $user !== null
            ? (Core::get()->db->performQuery(
                "SELECT SUM(quantity) as total FROM cart_items WHERE user_id = :user_id",
                ['user_id' => $user['id']]
            )[0]['total'] ?? 0)
            : array_sum($_SESSION['cart'] ?? []);

        return $this->redirect('/cart/index#cart');
    }
    public function actionAjaxhtml()
    {
        $user = \models\Users::GetCurrentAuthenticatedUser();
        $cartItems = [];

        if ($user !== null) {
            $cartItems = Core::get()->db->performQuery("SELECT ci.*, p.name, p.image, p.price FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.user_id = :user_id", [
                'user_id' => $user['id']
            ]);
        } elseif (!empty($_SESSION['cart'])) {
            $ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = Core::get()->db->pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                $cartItems[] = [
                    'product_id' => $product['id'],
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'price' => $product['price'],
                    'quantity' => $_SESSION['cart'][$product['id']]
                ];
            }
        }

        $this->template->setParams(['items' => $cartItems]);
        return $this->renderPartial('cart/ajax_cart');
    }

}