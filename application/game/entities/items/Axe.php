<?php

class Axe extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->sub_num = $data->sub_num; //Колличество затрачиваемой прочности за удар
        $this->damage = $data->damage; //Урон наносимый топором
        //Можно сделать отдельно урон живности и допустим деревьям, то есть растительности
        $this->craft_resurses = $data->craft_resurses; //Объект с ресурсами для крафт топора
    }

    

}
