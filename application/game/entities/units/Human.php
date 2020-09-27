<?php

class Human extends Animal {
    function __construct($data)
    {
        parent::__construct($data);
        $this->movespeed = $data->movespeed;
        $this->damage = $data->damage;
        $this->range = $data->range;
        $this->attack_speed=$data->attack_speed;
    }
}
