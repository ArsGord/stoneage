<?php

class Stone extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->type = 'resource';
        $this->count = $data->count; // количество камня
    }
}
