<?php

class DB {
    public function __construct() {

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

    public function updateInventory($humanId) {
        print_r("db->updateInevntory()</br>");
        //$this->getHumanByUserId($humanId);
    }

    public function dropItem($itemId) {
        print_r("db->dropItem()</br>");
    }
}