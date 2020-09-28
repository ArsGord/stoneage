<?php

require_once ("Animal.php");

    class Rock extends Entity {
        function __construct($data) {
            parent::__construct($data);
            $this->count = $data->count;
        }
    }
