<?php

class DB {
    function __construct() {
        $host = "127.0.0.1:3308";
        $user = "root";
        $pass = "";
        $name = "stoneage";
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    function __destruct() {
        $this->conn = null;
    }

    public function getUserByLogin($login) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE login='$login'");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getUserByToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE token='$token'");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateToken($id, $token) {
        $stmt = $this->conn->prepare("UPDATE users SET token='$token' WHERE id=$id");
        $stmt->execute();
        return true;
    }

    public function createUser($nickname, $login, $hash, $token) {
        if ($nickname && $login && $hash && $token) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE login='$login'");
            $stmt->execute();
            if (!$stmt->fetch()) {
                $stmt = $this->conn->prepare("INSERT INTO `users` (`name`, `login`, `password`, `token`) VALUES ('$nickname', '$login', '$hash', '$token')");
                $stmt->execute();
                return $token;
            }
        }
        return false;
    }

    public function getHumanByUserId($userId) {
        return (object) [
            'x' => 1,
            'y' => 1
        ];
    }

    public function getMap() {
        $stmt = $this->conn->prepare("SELECT * FROM maps WHERE id = 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getTiles() {
        $stmt = $this->conn->prepare("SELECT * FROM tiles");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getFreeItems() {
        return [(object)['x' => 1, 'y' => 1]];
    }

    public function takeItem($humanId, $itemId) {
        print_r("db->takeItem()</br>");
    }

    public function dropItem($itemId) {
        print_r("db->dropItem()</br>");
    }

    public function getItemById($itemId) {
        return ['calories' => 10, 'count' => 2];
    }

    public function updateInventory($humanId) {
        //$this->getHumanByUserId($humanId);
    }
}