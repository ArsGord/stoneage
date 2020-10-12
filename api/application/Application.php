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
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->takeItem($user->id);
        }
    }

    public function dropItem($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->dropItem($user->id, $params['hand']);
        }
    }

    public function putOn($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->putOn($user->id);
        }
    }

    public function putOnBackpack($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->putOnBackpack($user->id);
        }
    }

    public function hit($params) {
        $user = $this->user->getUserByToken($params['token']);

    }

    public function repair($params) {
        $user = $this->user->getUserByToken($params['token']);

    }

    public  function fix($params) {
        $user = $this->user->getUserByToken($params['token']);

    }

    public function eat($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->eat($user->id);
        }
    }

    public function makeItem($params) {
        $user = $this->user->getUserByToken($params['token']);

    }

    public function makeBuilding($params) {
        $user = $this->user->getUserByToken($params['token']);

    }

    public function keepBuilding($params) {
        $user = $this->user->getUserByToken($params['token']);

    }
}