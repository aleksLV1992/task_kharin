<?php

namespace models;


use vendor\Models;

class Login extends Models
{
    public $user_name;
    public $password;
    const SESSION_NAME = "LOGIN_USER";
    private $user;

    /**
     * Получения Именени таблицы в БД
     * @return string
     */
    private static function getTable()
    {
        return 'users';
    }

    /**
     * Проверка валидности модели
     * @return bool
     */
    public function valid()
    {
        $isValid = false;
        if (strlen($this->user_name) === 0) {
            $this->errorList [] = "Заполните Имя пользователя";
        } else if (strlen($this->password) === 0) {
            $this->errorList [] = "Заполните Пароль";
        } else {
            $this->user = $this->getUserLogin($this->user_name);

            if (!empty($this->user) && $this->user['password'] = md5($this->password)) {
                $isValid = true;
            } else {
                $this->errorList [] = "Неверный имя пользователя или пароль";
            }
        }
        return $isValid;
    }

    /**
     * Возврашает пользователя по логину
     * @param $login
     * @return null
     */
    private function getUserLogin($login)
    {
        $table = self::getTable();
        $stmt = \vendor\Site::$db->prepare("SELECT * FROM {$table} WHERE user_name = :u");
        $stmt->execute([':u' => $login]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
/*        if (count($user) > 0)
            return $user[0];*/
        return $user;
    }

    /**
     * Деавторизация
     */
    public function login()
    {

        session_start();
        $_SESSION[self::SESSION_NAME] = json_encode($this->user);
    }

    /**
     * Деавторизация
     */
    public function logout()
    {
        session_start();
        unset($_SESSION[self::SESSION_NAME]);
        session_destroy();
    }

    /**
     * Получения текушего пользователя
     */
    public static function getUser()
    {
        $user = false;
        session_start();
        if (isset($_SESSION[self::SESSION_NAME])) {
            $user = json_decode($_SESSION[self::SESSION_NAME]);
        }

        return $user;

    }
}