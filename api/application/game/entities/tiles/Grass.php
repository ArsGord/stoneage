<?php

class Grass extends Entity
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->size = $data->size; // стадия роста
        $this->count = $data->count; // пищевая ценность для животного
        $this->passability = true;
    }

    public function hit($damage = 0) {
        // если нанесен урон, то нанести его
        if ($damage > 0) {
            return parent::hit($damage);
        }
        return parent::hit();
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