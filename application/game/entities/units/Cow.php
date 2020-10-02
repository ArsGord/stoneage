<?php

require_once ("Animal.php");

class Cow extends Animal {
    function __construct($data) {
        parent::__construct($data);
        $this->weight = $data->weight;
        $this->x = $data->x;
        $this->y = $data->y;
    }

    protected function destroy() {
        // вернуть еду в зависимости от веса коровки
        return new Food((object) [
                'count' => $this->weight,
                'x' => $this->x,
                'y' =>$this->y
        ]);
    }
}