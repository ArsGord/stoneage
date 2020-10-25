<?php

class DB {
    public function __construct() {

    }

    public function createUser($nickname, $login, $token) {
        if ($nickname && $login && $token) {
            // создать пользователя
            return true;
        }
        return false;
    }

    public function getUserByLogin($login) {

    }

    public function getHumanByUserId($userId) {
        return (object) [
            'x' => 1,
            'y' => 1
        ];
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
        return (object)['calories' => 10, 'count' => 2];
    }

    public function updateInventory($humanId) {
        //$this->getHumanByUserId($humanId);
    }
}