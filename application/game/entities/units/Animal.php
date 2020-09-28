<?php

require_once("Heroes_of_VM-21_Stone_Age/application/game/entities/Entity.php");

class Animal extends Entity {
    public function __construct($data){
        parent::__construct($data);
        $this->satiety = $data->satiety;
    }
}
