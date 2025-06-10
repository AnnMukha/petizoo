<?php

namespace models;

use core\Core;
use core\Model;

/**
 * @property int $id ID
 * @property string $login Логін
 * @property string $password Пароль
 * @property string $firstname Ім'я
 * @property string $lastname Прізвище
 */
class Users extends Model
{
    public static $tableName = 'users';
    public static function FindByLoginAndPassword($login, $password) {
        $user = self::FindByLogin($login);
        if (!empty($user) && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
    public static function FindByLogin($login) {
        $rows = self::findByCondition(['login' => $login]);
        if (!empty($rows))
            return $rows[0];
        else
            return null;
    }
    public static function IsUserLogged() : bool
    {
        return !empty(Core::get()->session->get('user'));
    }
    public static function LoginUser($user) {
        Core::get()->session->set('user', [
            'id' => $user['id'],
            'login' => $user['login'],
            'is_admin' => $user['is_admin'] ?? 0,
            'firstname' => $user['firstname'] ?? '',
            'lastname' => $user['lastname'] ?? '',
            'phone' => $user['phone'] ?? '',
            'created_at' => $user['created_at'] ?? '',
        ]);
    }

    public static function LogoutUser() {
        Core::get()->session->remove('user');
        unset($_SESSION['cart']);
        unset($_SESSION['cart_count']);
    }
    public static function RegisterUser($login, $password, $lastname, $firstname) {
        $user = new Users();
        $user->login = $login;
        $user->password = $password;
        $user->lastname = $lastname;
        $user->firstname = $firstname;
        $user->save();
    }
    public static function GetCurrentAuthenticatedUser()
    {
        return $_SESSION['user'] ?? null;
    }

    public static function GetCurrentUser()
    {
        if (!self::IsUserLogged())
            return null;

        $userId = $_SESSION['user']['id'];
        return self::findById($userId);
    }
    public static function findById($id)
    {
        return self::findByCondition(['id' => $id])[0] ?? null;
    }
    public static function IsAdmin(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1;
    }
}