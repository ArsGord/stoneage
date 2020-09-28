<?php

class Axe extends Weapon {
    function __construct($data) {
        parent::__construct($data);
        $this->sub_num = $data->sub_num; //Колличество затрачиваемой прочности за удар
        $this->craft_resurses = $data->craft_resurses; //Объект с ресурсами для крафт топора
    }



}
