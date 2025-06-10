<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Users;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $user = Users::GetCurrentAuthenticatedUser();
        if (!$user) return $this->redirect('/users/login');

        $this->template->setParams([
            'user' => $user
        ]);
        return $this->render('profile/index');
    }

    public function actionOrders()
    {
        $user = Users::GetCurrentAuthenticatedUser();
        if (!$user) return $this->redirect('/users/login');

        $orders = Core::get()->db->select('orders', '*', ['user_id' => $user['id']], 'ORDER BY id DESC');
        $this->template->setParams(['orders' => $orders]);
        return $this->render('profile/orders');
    }

    public function actionOrder()
    {
        if (!Users::IsUserLogged())
            return $this->redirect('/users/login');

        $user = Users::GetCurrentAuthenticatedUser();
        $orderId = $_GET['id'] ?? null;

        if (!$orderId)
            return $this->redirect('/profile/orders');

        $order = Core::get()->db->select('orders', '*', [
            'id' => $orderId,
            'user_id' => $user['id']
        ]);

        if (empty($order))
            return $this->redirect('/profile/orders');

        $items = Core::get()->db->performQuery("
            SELECT oi.*, p.name, p.image 
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :id
        ", ['id' => $orderId]);

        $this->template->setParams([
            'order' => $order[0],
            'items' => $items
        ]);
        return $this->render('profile/order');
    }

    public function actionFavorites()
    {
        $user = Users::GetCurrentAuthenticatedUser();
        if (!$user) return $this->redirect('/users/login');

        $favorites = Core::get()->db->performQuery(
            "SELECT p.* FROM favorites f
            JOIN products p ON p.id = f.product_id
            WHERE f.user_id = :user_id",
            ['user_id' => $user['id']]
        );

        $this->template->setParams(['favorites' => $favorites]);
        return $this->render('profile/favorites');
    }

    public function actionSettings()
    {
        if (!Users::IsUserLogged()) {
            return $this->redirect('/users/login');
        }
        $user = Users::GetCurrentAuthenticatedUser();
        $errors = [];
        $success = null;
        if ($this->isPost) {
            $field = $this->post->field ?? null;
            $value = trim($this->post->value ?? '');
            $updatedFields = [];
            switch ($field) {
                case 'firstname':
                    if ($value === '') {
                        $errors[] = 'Ім’я не може бути порожнім';
                    } else {
                        $updatedFields['firstname'] = $value;
                    }
                    break;
                case 'lastname':
                    if ($value === '') {
                        $errors[] = 'Прізвище не може бути порожнім';
                    } else {
                        $updatedFields['lastname'] = $value;
                    }
                    break;
                case 'email':
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'Некоректний email';
                    } else {
                        $updatedFields['login'] = $value;
                    }
                    break;
                case 'phone':
                    if (!preg_match('/^\+380\d{9}$/', $value)) {
                        $errors[] = 'Телефон має бути у форматі +380XXXXXXXXX';
                    } else {
                        $updatedFields['phone'] = $value;
                    }
                    break;
                case 'password':
                    if ($value === '') {
                        $errors[] = 'Пароль не може бути порожнім';
                    } else {
                        $updatedFields['password'] = password_hash($value, PASSWORD_DEFAULT);
                    }
                    break;
                default:
                    $errors[] = 'Невідоме поле для оновлення.';
                    break;
            }
            if (empty($errors) && !empty($updatedFields)) {
                Core::get()->db->update('users', $updatedFields, ['id' => $user['id']]);
                $user = Core::get()->db->select('users', '*', ['id' => $user['id']])[0];
                $_SESSION['user'] = $user;
                $success = 'Зміни успішно збережено!';
            }
        }
        return $this->render([
            'user' => $user,
            'errors' => $errors,
            'success' => $success
        ]);
    }

}