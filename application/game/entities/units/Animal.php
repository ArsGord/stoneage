<?php

require_once "../Entity.php";

class Animal extends Entity {
    public function __construct($data){
        parent::__construct($data);
        $this->satiety = $data->satiety;
    }

    public function hit($damage = 0) {
        // если нанесен урон, то нанести его
        if ($damage > 0) {
            return parent::hit($damage);
        }
        // уменьшить сытость
        if ($this->satiety > 0) {
            $this->satiety--;
            return null;
        }
        // нанести урон, если сытость стала нулевой
        $this->hp--;
        return parent::hit();
    }
}
