<?php
//
class Clothes extends Entity {
    public function __construct($data){
        parent::__construct($data);
        $this->type = 'clothes';
        $this->protection = $data->protection;
    }
}