<?php
//
class Clothes extends Entity {
    public function __construct($data){
        parent::__construct($data);
        $this->protection = $data->protection;
    }
}