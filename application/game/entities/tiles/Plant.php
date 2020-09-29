<?php

class Plant extends Entity
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->size = $data->size; // стадия роста
        $this->count = $data->count; // энергетическая ценность для животных
        $this->edible = $data->edible; // съедобное или не съедобное
    }

    private function stageUp() {
        $this->stage++;
    }
}