<?php

class Wall extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->length = $data->length; //длина
    }
}