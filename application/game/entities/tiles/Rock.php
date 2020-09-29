<?php

class Rock extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->count = $data->count;
    }
    public function hit($damage = 0) {
        if ($damage > 0) {
            return parent::hit($damage);
        }

    }
}
