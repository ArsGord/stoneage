<?php

//require_once ('db/DB.php');
//require_once ('user/User.php');

class Application {
    public function __construct() {
        $db = new DB();
        $this->user = new User($db);
        // ..
    }

    public function login ($params) {
        if ($params['login'] && $params['password']) {
            return $this->user ->login ($params['login'], $params['password']);
        }
        return false;
    }
}