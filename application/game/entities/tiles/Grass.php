<?php

require_once("../Entity.php");

class Grass extends Entity
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->stage = $data->stage; // стадия роста дерева
    }
}