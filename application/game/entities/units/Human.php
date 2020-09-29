<?php

class Human extends Animal {
    function __construct($data) {
        parent::__construct($data);
        $this->body=$data->body;
        $this->left_hand=$data->left_hand;
        $this->right_hand=$data->right_hand;
        $this->backpack=$data->backpack;
    }

    public function hit($damage = 0) {
        // если нанесен урон, то нанести его с учетом брони и одежды
        if ($damage > 0) {
            // учесть защиту игрока, вычесть часть дамаги из предметов
            // нанести оставшуюся дамагу с помощью
            return parent::hit($damage);
        }
        return parent::hit();
    }

    protected function destroy() {
        // Все, что лежит в карманах, вывалить на карту (предметам задать x, y)
    }
}
