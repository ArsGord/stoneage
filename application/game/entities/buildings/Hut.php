<?php

class Hut extends Entity {
    function __construct($data){
        parent::__construct($data);
        $this->armor = $data->armor; //броня
        $this->capacity = $data->capacity; //вместимость
    }

    function put_item($item) {
        if($this->capacity < 10) {
            $item->x = $this->x;
            $item->y = $this->y;
            $this->capacity++;
        }
    }
}