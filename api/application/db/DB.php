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
        return $stmt->fetch();
    }

    public function getGamer($gamerId) {
        $stmt = $this->conn->prepare("SELECT * FROM gamer WHERE id='$gamerId'");
        $stmt->execute();
        $gamer = $stmt->fetch();
        $stmt = $this->conn->prepare("SELECT * FROM items WHERE gamer_id='$gamerId'");
        $stmt->execute();
        $items = $stmt->fetchAll();
        for ($i = 0; $i < count($items); $i++) {
            if($items[$i]['inventory'] === 'left_hand') {
                $gamer['left_hand'] = $items[$i];
            }
            elseif($items[$i]['inventory'] === 'right_hand') {
                $gamer['left_hand'] = $items[$i];
            }
            elseif ($items[$i]['inventory'] === 'backpack') {
                $gamer['backpack'] = $items[$i];
            }
        }
        return $gamer;
    }

    public function getGamers() {
        $stmt = $this->conn->prepare("SELECT id FROM gamer WHERE status='online'");
        $stmt->execute();
        $gamers = $stmt->fetchAll();
        foreach($gamers as $id) {
            $gamersId[] = (integer)$id['id'];
        }
        foreach($gamersId as $id) {
            $Gamers[] = $this->getGamer($id);
        }
        return $Gamers;
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

    public function updateMap($hash) {
        $stmt = $this->conn->prepare("SELECT hash FROM maps");
        $stmt->execute();
        $dbHash = $stmt->fetch();
        if ($dbHash['hash'] != $hash){
            return $dbHash['hash'];
        }
        return false;
    }

    public function getFreeItems() {
        return [(object)['x' => 1, 'y' => 1]];
    }

    public function takeItem($humanId, $itemId) {

    }

    public function dropItem($itemId) {

    }

    public function getItemById($itemId) {
        return ['calories' => 10, 'count' => 2];
    }

    public function updateInventory($humanId) {
        //$this->getHumanByUserId($humanId);
    }
}