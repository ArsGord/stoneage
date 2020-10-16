<?php

class Food extends Entity {
    public function __construct($data){
        parent::__construct($data);
        $this->type = 'food';
        $this->count = $data->count; // количество еды
        $this->calories = $data->calories; // энергетическая ценность
    }
}