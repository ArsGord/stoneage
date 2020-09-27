<?php

class Bow extends Weapon {
    function __construct($data)
    {
        parent::__construct($data);
        $this->aiming = $data->aiming;
    }
}
