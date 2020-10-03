<?php
require_once 'db/DB.php';
require_once "game/Game.php";

class Application {
    public function __construct() {
        $db = new DB();
        $this->game = new Game($db);
    }

    public function test($params) {
        if ($params['entity']) {
            return $this->game->test($params['entity']);
        }
        return false;
    }
}