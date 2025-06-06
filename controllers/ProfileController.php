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

    public function actionFavorites()
    {
        $user = Users::GetCurrentAuthenticatedUser();
        if (!$user) return $this->redirect('/users/login');

        $favorites = Core::get()->db->performQuery("
            SELECT p.* FROM favorites f
            JOIN products p ON p.id = f.product_id
            WHERE f.user_id = :user_id
        ", ['user_id' => $user['id']]);

        $this->template->setParams(['favorites' => $favorites]);
        return $this->render('profile/favorites');
    }

    public function actionSettings()
    {
        $user = Users::GetCurrentAuthenticatedUser();
        if (!$user) return $this->redirect('/users/login');

        if ($this->isPost) {
            $newName = $this->post->name;
            $email = $this->post->email;
            $phone = $this->post->phone;

            Core::get()->db->update('users', [
                'name' => $newName,
                'email' => $email,
                'phone' => $phone
            ], ['id' => $user['id']]);

            $_SESSION['user'] = Core::get()->db->select('users', '*', ['id' => $user['id']])[0];
            $_SESSION['success'] = 'Дані оновлено!';
            return $this->redirect('/profile/settings');
        }

        $this->template->setParams(['user' => $user]);
        return $this->render('profile/settings');
    }
}