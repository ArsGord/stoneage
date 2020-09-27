<?php

    class Tree extends Entity {
        function __construct($data) {
            parent::__construct($data);
            $this->size = $data->size;
            $this->type = $data->type;
            $this->count = $data->count;
        }
    }