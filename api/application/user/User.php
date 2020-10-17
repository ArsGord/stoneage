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

    public function login($login, $hash) {
        $user = $this->db->getUserBylogin($login);
        if ($user) {
            $hash5 = md5($user->password.rand(1, 100000));
            if($hash === $hash5) {
                $token = md5($hash);
                return $token;
            }
        }
        return false;
    }
}