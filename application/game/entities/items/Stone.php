<?php

class Stone extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->pebbles = $data->pebbles;
    }
}