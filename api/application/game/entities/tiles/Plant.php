<?php

class Plant extends Entity
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->size = $data->size; // стадия роста
        $this->count = $data->count; // энергетическая ценность для животных
        $this->isEdible = $data->isEdible; // съедобное или не съедобное
        $this->passability = true;
    }

    // уничтожение
    protected function destroy() {
        return null;
    }

    // увеличение размера
    private function sizeUp($flag) {
        if ($flag) {
            $this->size++;
        }
    }
}