<?php

require_once ("Entitys.php");

class Animal extends Entitys{
    function __construct($data) {
        parent::__construct($data);
        $this->satiety = $data->satiety;
        $this->age = $data->age;
    }
}