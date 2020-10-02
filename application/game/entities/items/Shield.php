<?php

class Shield extends Weapon {
    function __construct($data)
    {
        parent::__construct($data);
        $this->protection = $data->protection; // защита
    }
}