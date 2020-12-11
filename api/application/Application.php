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

    public function login($params) {
        if ($params['login'] && $params['hash'] && $params['num']) {
            return $this->user->login($params['login'], $params['hash'], $params['num']);
        }
        return false;
    }

    public function logout($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            $this->leave($user['id']);
            return $this->user->logout($params['token']);
        }
        return false;
    }

    public function registration($params) {
        if ($params) {
            return $this->user->registration($params['nickname'], $params['login'], $params['hash'], $params['token'], $params['num']);
        }
        return false;
    }

    public function join($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->join($user['id']);
        }
    }

    public function leave($userId) {
        if ($userId) {
            return $this->game->leave($userId);
        }
    }

    public function getMap($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->getMap();
        }
    }

    public function updateMap($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->updateMap($params['hash']);
        }
    }

    public function changeHash() {
        return $this->game->changeHash();
    }

    public function getGamers() {
        return $this->game->getGamers();
    }
    public function getGamer($params) {
        return $this->game->getGamer($params['gamerId']);
    }

    public function move($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->move($user['id'], $params['direction']);
        }
    }

    public function takeItem($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->takeItem($user['id']);
        }
    }

    public function dropItem($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->dropItem($user['id']/*, $params['hand']*/);
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
            return $this->game->putOnBackpack($user['id']);
        }
    }

    public function repair($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->repair($user->id);
        }
    }

    public  function fix($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->fix();
        }
    }

    public function eat($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->eat($user->id);
        }
    }

    public function makeItem($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->makeItem($user->id);
        }
    }

    public function makeBuilding($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->makeBuilding();
        }
    }

    public function keepBuilding($params) {
        $user = $this->user->getUserByToken($params['token']);
        if ($user) {
            return $this->game->keepBuilding();
        }
    }
}