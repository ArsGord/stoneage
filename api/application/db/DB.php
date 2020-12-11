<?php

class DB {
    function __construct() {
        $host = "127.0.0.1:3306";
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

    public function changeHash() {
        $hash = md5(rand());
        $stmt = $this->conn->prepare("UPDATE maps SET hash='$hash'");
        $stmt->execute();
        return true;
    }

    public function getGamer($id) {
        $stmt = $this->conn->prepare("SELECT * FROM gamer WHERE id=$id");
        $stmt->execute();
        $gamer = $stmt->fetchObject();
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE gamer_id=$id");
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_CLASS);
        for ($i = 0; $i < count($items); $i++) {
            if($items[$i]->inventory === 'left_hand') {
                $gamer->left_hand = $items[$i];
            } elseif($items[$i]->inventory === 'right_hand') {
                $gamer->right_hand = $items[$i];
            } elseif ($items[$i]->inventory === 'backpack') {
                $gamer->backpack = $items[$i];
            } elseif($items[$i]->inventory === 'body') {
                $gamer->body = $items[$i];
            }
        }
        return $gamer;
    }

    public function getGamers() {
        $stmt = $this->conn->prepare("SELECT id FROM gamer WHERE status='online'");
        $stmt->execute();
        $ids = $stmt->fetchAll();
        $gamers = array();
        foreach($ids as $id) {
            $gamers[] = $this->getGamer((integer)$id['id']);
        }
        return $gamers;
    }

    public function createGamer($userId) {
        $stmt = $this->conn->prepare("INSERT INTO `gamer` (`id`, `user_id`, `status`, `x`, `y`, `hp`, `satiety`) VALUES ('$userId', '$userId', 'online', 1, 1, 100, 100)");
        $stmt->execute();
        return $this->getGamer($userId);
    }

    public function join($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM gamer WHERE user_id='$userId'");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function setStatusOnline($userId) {
        $stmt = $this->conn->prepare("UPDATE gamer SET status='online' WHERE user_id='$userId'");
        $stmt->execute();
        return true;
    }

    public function leave($userId) {
        $stmt = $this->conn->prepare("UPDATE gamer SET status='offline' WHERE user_id='$userId'");
        $stmt->execute();
        return true;
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

    public function getMap() {
        $stmt = $this->conn->prepare("SELECT * FROM maps WHERE id = 1");
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public function getTiles() {
        $stmt = $this->conn->prepare("SELECT * FROM tiles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function updateMap($hash) {
        $stmt = $this->conn->prepare("SELECT hash FROM maps");
        $stmt->execute();
        $dbHash = $stmt->fetch();
        if ($dbHash['hash'] != $hash){
            return $dbHash['hash'];
        }
        return false;
    }

    public function updateGamer($params, $id) {
        foreach ($params as $key => $val) {
            $stmt = $this->conn->prepare("UPDATE gamer SET `$key`=$val WHERE `id`=$id");
            $stmt->execute();
        }
    }

    public function getItems() {
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE inventory = 'map'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function takeItem($humanId, $items) {
        foreach ($items as $key => $value) {
            $stmt = $this->conn->prepare("UPDATE items SET gamer_id = '$humanId', inventory = '$key' WHERE id = '$value->id'");
            $stmt->execute();
        }
    }

    public function dropItem($item, $x, $y) {
        $stmt = $this->conn->prepare("UPDATE items SET gamer_id = null, inventory = 'map', x = '$x', y = '$y' WHERE id = '$item->id'");
        $stmt->execute();
    }

    public function getItemById($itemId) {
        return ['calories' => 10, 'count' => 2];
    }

    public function updateInventory($humanId) {
        //$this->getHumanByUserId($humanId);
    }
}