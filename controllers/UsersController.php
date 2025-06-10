<?php

namespace controllers;

use core\Controller;
use models\Users;

class UsersController extends Controller
{
    public function actionLogin()
    {
        if (Users::IsUserLogged()) {
            return $this->redirect('/');
        }

        if ($this->isPost) {
            $user = Users::FindByLoginAndPassword($this->post->login, $this->post->password);

            if (!empty($user)) {
                Users::LoginUser($user);

                // 🔐 Перевірка чи це адмін
                if ($user['login'] === 'admin@petizoo.ua') {
                    return $this->redirect('/admin/dashboard');
                } else {
                    return $this->redirect('/');
                }
            } else {
                $this->addErrorMessage('Неправильний логін та/або пароль');
            }
        }
        return $this->render();
    }

    public function actionRegister() {
        if ($this->isPost) {
            $user = Users::FindByLogin($this->post->login);
            if (!empty($user)) {
                $this->addErrorMessage('Користувач із таким логіном вже існує');
            }
            if (strlen($this->post->login) === 0)
                $this->addErrorMessage('Логін не вказано');
            if (strlen($this->post->password) === 0)
                $this->addErrorMessage('Пароль не вказано');
            if (strlen($this->post->password2) === 0)
                $this->addErrorMessage('Пароль (ще раз) не вказано');
            if ($this->post->password != $this->post->password2)
                $this->addErrorMessage('Паролі не співпадають');
            if (strlen($this->post->lastname) === 0)
                $this->addErrorMessage('Прізвище не вказано');
            if (strlen($this->post->firstname) === 0)
                $this->addErrorMessage('Ім\'я не вказано');
            if (!$this->isErrorMessageExists()) {
                $hashedPassword = password_hash($this->post->password, PASSWORD_DEFAULT);
                Users::RegisterUser(
                    $this->post->login,
                    $hashedPassword,
                    $this->post->lastname,
                    $this->post->firstname
                );
                return $this->redirect('/users/registersuccess');
            }
        }
        return $this->render();
    }

    public function actionRegistersuccess()
    {
        return $this->render();
    }

    public function actionLogout()
    {
        Users::LogoutUser();
        unset($_SESSION['cart']);
        unset($_SESSION['cart_count']); // 🔄 Очистити лічильник кошика

        return $this->redirect('/users/login');
    }
}
