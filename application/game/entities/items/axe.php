<?php

class Axe extends Entity {
    function __construct($data, $arguments) {
        parent::__construct($data);
        $this->sub_num = $arguments->sub_num; //Колличество затрачиваемой прочности за удар
        $this->quality = $arguments->quality; //Качество сделанного топора
        $this->damage = $arguments->damage; //Урон наносимый топором
        //Можно сделать отдельно урон живности и допустим деревьям, то есть растительности
        $this->craft_resurses = $arguments->craft_resurses; //Объект с ресурсами для крафт топора
            //Чего не хватает???
    }

    

}