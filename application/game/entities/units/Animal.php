<?php

class Animal extends Entity {
    public function __construct($data){
        parent::__construct($data);
        $this->satiety = $data->satiety;
    }
}
