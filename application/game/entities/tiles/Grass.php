<?php

class Grass extends Entity
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->stage = $data->stage; // стадия роста
        $this->count = $$data->count; // пищевая ценность для животного
    }

    public function voice() {
        print_r("Hello, I'm grass!!!");
    }
}