<?php

class Food extends Entity {
    public function __construct($data){
        parent::__construct($data);
        $this->count = $data->count; // количество еды
    }
}