<?php
require_once 'db/DB.php';
require_once "user/User.php";
require_once "game/Game.php";

class Application {
    public function __construct() {
        $db = new DB();
        $this->user = new User($db);
        $this->game = new Game($db);
    }

    public function test($params) {
        if ($params['entity']) {
            return $this->game->test($params['entity']);
        }
    }

    public function move($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->move($user->id, $params['direction']);
        }
    }

    public function takeItem($params) {
        $user = $this->user->getUserByToken(($params['token']));
        if ($user) {
            return $this->game->takeItem($user->id);
        }
    }

    public function dropItem($userId, $itemId) {

    }

    public function putOn($userId, $itemId) {

    }

    public function putIn($userId, $itemId) {

    }

    public function hit($userId, $direction) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($userId && $direction) {

        }
    }

    public function repair($userId, $itemId) {

    }

    public  function fix($userId, $buildingId) {

    }

    public function eat($userId, $itemId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($userId && $itemId) {
            return $human->eat($itemId);
        }
    }

    public function makeItem($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));

    }

    public function makeBuilding($userId) {

    }

    public function keepBuilding($params) {

    }
}