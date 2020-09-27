<?php

    class Rock extends Entity {
        function __construct($data) {
            parent::__construct($data);
            $this->size = $data->size;
            $this->count = $data->count;
        }
    }