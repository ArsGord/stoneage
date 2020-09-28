<?php

require_once("Heroes_of_VM-21_Stone_Age/application/game/entities/units/Animal.php");

class Human extends Animal {
    function __construct($data)
    {
        parent::__construct($data);
        $this->body=$data->body;
        $this->left_hand=$data->left_hand;
        $this->right_hand=$data->right_hand;
        $this->backpack=$data->backpack;
    }
}
