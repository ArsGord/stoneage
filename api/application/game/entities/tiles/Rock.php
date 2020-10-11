<?php

class Rock extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->count = $data->count;
        $this->passability = false;
    }

    public function hit($damage = 0) {
        // если нанесен урон, то нанести его
        if ($damage > 0) {
            return parent::hit($damage);
        }
        return parent::hit();
    }

    // уничтожение
    protected function destroy(){
        return new Stone((object) [
            'count' => $this->count,
            'x' => $this->x,
            'y' => $this->y
        ]);
    }
}
