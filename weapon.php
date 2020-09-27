<?php

class Weapon extends Entity {
    function __construct(&data)
    {
        parent::__construct($data);
        $this->attack_range = $data->attack_range;
        $this->damage = $data->damage;
        $this->attack_speed = $data->attack_speed;
    }
}
