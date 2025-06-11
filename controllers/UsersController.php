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

        $error_message = '';

        if ($this->isPost) {
            $login = trim($this->post->login ?? '');
            $password = $this->post->password ?? '';

            if ($login === '' || $password === '') {
                $error_message = 'Будь ласка, заповніть всі поля';
            } else {
                $user = Users::FindByLoginAndPassword($login, $password);

                if (!empty($user)) {
                    Users::LoginUser($user);

                    if ($user['login'] === 'admin@petizoo.ua') {
                        return $this->redirect('/admin/dashboard');
                    } else {
                        return $this->redirect('/');
                    }
                } else {
                    $error_message = 'Неправильний логін та/або пароль';
                }
            }
        }

        return $this->render(['error_message' => $error_message]);
    }

    public function actionRegister() {
        if ($this->isPost) {
            $errors = [];

            $login = trim($this->post->login ?? '');
            $password = $this->post->password ?? '';
            $password_confirm = $this->post->password_confirm ?? '';
            $lastname = trim($this->post->lastname ?? '');
            $firstname = trim($this->post->firstname ?? '');

            if ($login === '') {
                $errors[] = 'Логін не вказано';
            } elseif (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Введіть коректний email';
            }

            if ($password === '') {
                $errors[] = 'Пароль не вказано';
            } else {
                if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{6,}$/', $password)) {
                    $errors[] = 'Пароль має містити мінімум 8 символів, включно з літерами, цифрами та спеціальними символами';
                }
            }

            if ($password_confirm === '') {
                $errors[] = 'Пароль (ще раз) не вказано';
            }

            if ($password !== $password_confirm) {
                $errors[] = 'Паролі не співпадають';
            }

            if ($lastname === '') {
                $errors[] = 'Прізвище не вказано';
            }

            if ($firstname === '') {
                $errors[] = 'Ім\'я не вказано';
            }

            $user = Users::FindByLogin($login);
            if (!empty($user)) {
                $errors[] = 'Користувач із таким логіном вже існує';
            }

            if (!empty($errors)) {
                return $this->render(['errors' => $errors]);
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            Users::RegisterUser($login, $hashedPassword, $lastname, $firstname);

            return $this->redirect('/users/registersuccess');
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
        unset($_SESSION['cart_count']);

        return $this->redirect('/users/login');
    }
}
