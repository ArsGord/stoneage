<?php

class Hut extends Entity {
    function __construct($data){
        parent::__construct($data);
        $this->armor = $data->armor; //броня
        $this->capacity = $data->capacity; //вместимость
    }
}