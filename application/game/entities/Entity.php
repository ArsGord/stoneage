<?php

class Entity {
    function __construct($data) {
        $this->id        = $data->id;
        $this->entity_id = $data->entity_id;
        $this->image     = $data->image;
        $this->name      = $data->name;
        $this->hp        = $data->hp;
        $this->x         = $data->x;
        $this->y         = $data->y;
    }

    protected function destroy() {
        return null;
    }

    public function repair() {
        return $this->hp;
    }

    public function hit($damage = 0) {
        // если урон нанесен - вычесть здоровье
        if ($damage > 0) {
            $this->hp -= $damage;
        }
        // умереть, если здоровье меньше нуля
        if ($this->hp <= 0) {
            return $this->destroy();
        }
    }
}
