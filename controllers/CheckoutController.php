<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Users;

class CheckoutController extends Controller
{
    public function actionIndex()
    {
        $user = Users::GetCurrentAuthenticatedUser();
        $items = [];

        if ($user !== null) {
            $items = Core::get()->db->performQuery(
                "SELECT ci.*, p.name, p.price, p.image, p.stock 
                 FROM cart_items ci 
                 JOIN products p ON p.id = ci.product_id 
                 WHERE ci.user_id = :user_id",
                ['user_id' => $user['id']]
            );
        } elseif (!empty($_SESSION['cart'])) {
            $ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = Core::get()->db->pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($ids);
            $products = $stmt->fetchAll();
            foreach ($products as $product) {
                $items[] = [
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
            'items' => $items,
            'isGuest' => ($user === null),
            'total' => array_reduce($items, fn($carry, $item) => $carry + $item['price'] * $item['quantity'], 0)
        ]);
        return $this->render('checkout/index');
    }

    public function actionSubmit()
    {
        if (!$this->isPost) return $this->redirect('/checkout');

        $fullName = $this->post->full_name;
        $phone = $this->post->phone;
        $deliveryType = $this->post->delivery_type;
        $city = $this->post->city;
        $department = $this->post->department;
        $address = "$deliveryType, $city, $department";

        if (empty($fullName) || empty($phone) || empty($city) || empty($department)) {
            $_SESSION['error'] = 'Будь ласка, заповніть усі обов’язкові поля.';
            return $this->redirect('/checkout');
        }

        if (!preg_match('/^\+380\d{9}$/', $phone)) {
            $_SESSION['error'] = 'Телефон повинен бути у форматі +380XXXXXXXXX.';
            return $this->redirect('/checkout');
        }

        $user = Users::GetCurrentAuthenticatedUser();
        $userId = $user['id'] ?? null;
        $hasDiscount = $user !== null;

        $items = [];
        if ($user !== null) {
            $items = Core::get()->db->performQuery(
                "SELECT ci.*, p.price, p.stock 
                 FROM cart_items ci 
                 JOIN products p ON p.id = ci.product_id 
                 WHERE ci.user_id = :user_id",
                ['user_id' => $user['id']]
            );
        } elseif (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $qty) {
                $product = Core::get()->db->select('products', '*', ['id' => $id])[0];
                $items[] = [
                    'product_id' => $id,
                    'quantity' => $qty,
                    'price' => $product['price'],
                    'stock' => $product['stock']
                ];
            }
        }

        if (empty($items)) {
            $_SESSION['error'] = 'Ваш кошик порожній.';
            return $this->redirect('/checkout');
        }

        foreach ($items as $item) {
            if ($item['quantity'] > $item['stock']) {
                $_SESSION['error'] = "На складі лише {$item['stock']} шт. товару з ID {$item['product_id']}.";
                return $this->redirect('/checkout');
            }
        }

        $originalTotal = array_reduce($items, fn($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);
        $finalTotal = $hasDiscount ? round($originalTotal * 0.95, 2) : $originalTotal;

        if ($user !== null) {
            $nameParts = explode(' ', trim($fullName));
            $firstname = $nameParts[0] ?? '';
            $lastname = $nameParts[1] ?? '';

            Core::get()->db->update('users', [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone
            ], ['id' => $userId]);

            $_SESSION['user']['firstname'] = $firstname;
            $_SESSION['user']['lastname'] = $lastname;
            $_SESSION['user']['phone'] = $phone;
        }

        $orderId = Core::get()->db->insert('orders', [
            'user_id' => $userId,
            'full_name' => $fullName,
            'phone' => $phone,
            'address' => $address,
            'original_price' => $originalTotal,
            'total_price' => $finalTotal,
            'status' => 'Опрацьовується',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        foreach ($items as $item) {
            Core::get()->db->insert('order_items', [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
            Core::get()->db->update('products', [
                'stock' => $item['stock'] - $item['quantity']
            ], ['id' => $item['product_id']]);
        }

        if ($user !== null) {
            Core::get()->db->delete('cart_items', ['user_id' => $user['id']]);
        } else {
            unset($_SESSION['cart']);
        }

        $_SESSION['cart_count'] = 0;
        $_SESSION['order_success'] = $orderId;
        return $this->redirect('/checkout/success');
    }

    public function actionSuccess()
    {
        $orderId = $_SESSION['order_success'] ?? null;

        if ($orderId === null) {
            return $this->redirect('/');
        }

        unset($_SESSION['order_success']);

        $this->template->setParams([
            'order_id' => $orderId,
            'info_message' => 'Наш консультант зв’яжеться з вами для уточнення деталей замовлення та способу оплати.'
        ]);
        return $this->render('checkout/success');
    }
}