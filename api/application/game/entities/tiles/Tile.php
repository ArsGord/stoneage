<?php

class Tile extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->type = $data->type;
    }


}