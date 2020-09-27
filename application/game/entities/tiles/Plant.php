<?php

require_once ("../Entity.php");

class Plant extends Entity
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->stage = $data->stage; // стадия роста растения
        $this->energyValue = $data->energyValue; // энергетическая ценность для животных
        $this->edible = $data->edible; // съедобное или не съедобное
    }

    private function stageUp() {
        $this->stage++;
    }
}