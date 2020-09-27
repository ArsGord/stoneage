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
}
