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
        $user = $this->db->getUserByLogin($login);
        if ($user) {
            $token = md5($user['password'] . (string)$num);
            if($hash === $token) {
                $result = $this->db->updateToken($user['id'], $token); // обновить токен в DB
                if ($result) {
                    return $token;
                }
            }
        }
        return false;
    }

    public function logout($token) {
        $user = $this->db->getUserByToken($token);
        if ($user) {
            $result = $this->db->updateToken($user['id'], null); // обновить токен в DB
            if ($result) {
                return true;
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