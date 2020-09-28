<?php

require_once "../Entity.php";

class Wood extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->count = $data->count;
        $this->x = $data->x;
        $this->y = $data->y;
    }
}
