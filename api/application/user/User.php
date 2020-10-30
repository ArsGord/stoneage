<?php
class User {
    function __construct($db) {
        $this->db = $db;
    }

    public function getUserByToken($token) {
        if ($token) {
            $obj = new stdClass();
            $obj->id = 4;
            return $obj;
        }
    }

    public function login($login, $hash, $num) {
        $user = (object) [ // для проверки
            'login' => $login,
            'password' => '123'
        ];
        //$user = $this->db->getUserBylogin($login);
        if ($user) { // нужно ли в $hash5 заменить $user->password на $user->hash ???
            $token = md5(md5( $user->login . $user->password) . (string)$num);
            if($hash === $token) {
                // обновить токен в DB
                return $token;
            }
        }
        return false;
    }

    public function registration($nickname, $login, $hash, $num) {
        if ($nickname && $login && $hash && $num) {
            // создаем нового user в DB
            $result = $this->db->createUser($nickname, $login, $hash, $num);
            if ($result) {
                return $result;
            }
            return false;
        }
    }
}