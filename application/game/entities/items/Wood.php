<?php

class Wood extends Entity {
    function __construct($data) {
        parent::__construct($data);
        $this->count = $data->count; // количество дерева
    }
}
