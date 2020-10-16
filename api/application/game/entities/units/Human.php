<?php

class Human extends Animal {
    function __construct($data) {
        parent::__construct($data);
        $this->body = $data->body;
        $this->left_hand = $data->left_hand;
        $this->right_hand = $data->right_hand;
        $this->backpack = $data->backpack;
        $this->protection = $data->protection;
    }

    public function hit($damage = 0) {
        // если нанесен урон, то нанести его с учетом брони и одежды
        if ($damage > 0) {
            // учесть защиту игрока, вычесть часть дамаги из предметов
            if($this->body->protection){
                $damage -= $this->body->protection;
            }
            // нанести оставшуюся дамагу с помощью
            return parent::hit($damage);
        }
        return parent::hit();
    }

    protected function destroy() {
        // Все, что лежит в карманах, вывалить на карту (предметам задать x, y)
        // предмет из левой руки
        // НУЖНО ПЕРЕДЕЛАТЬ
        /*if ($this->left_hand) {
            $this->left_hand->x = $this->x;
            $this->left_hand->y = $this->y;
        }
        // предмет из правой руки
        if ($this->right_hand) {
            $this->right_hand->x = $this->x;
            $this->right_hand->y = $this->y;
        }
        // предмет из рюкзака
        if ($this->backpack) {
            $this->backpack->x = $this->x;
            $this->backpack->y = $this->y;
        }
        // надетая на тело одежда
        if ($this->body) {
            $this->body->x = $this->x;
            $this->body->y = $this->y;
        }*/
    }

    public function move($map, $direction) {
        // взять непроходимые предметы на карте
        // выбираем непроходимые объекты на карте
        switch ($direction) {
            case 'left':
                $result = array();
                if ($this->x > 0) { // проверка на границу карты
                    $x = $this->x - 1;
                    $y = $this->y;
                    if (!($map[$x][$y]->passability)) {     // проверяем можно ли пройти
                        if (!(get_class($map[$x][$y]) === 'Water')) {   // если не вода, то бьем объект на карте
                            if ($this->right_hand && $this->right_hand->type === 'weapon') {
                                $map[$x][$y]->hit($this->right_hand->damage); // нужно ли менять, если в right_hand лежит id ???
                                $this->right_hand->hit(1);
                                $result[] = (object) [
                                    'type' => 'item',
                                    'id' => $this->right_hand->id,
                                    'hp' => $this->right_hand->hp
                                ];
                            } else {
                                $map[$x][$y]->hit(1);
                                $this->hit(1);
                            }
                            $result[] = (object) [
                                'type' => 'tile',
                                'id' => $map[$x][$y]->id,
                                'hp' => $map[$x][$y]->hp
                            ];
                        }
                    }
                    $result[] = (object) [
                        'type' => 'human',
                        'id' => $this->id,
                        'x' => $x,
                        'hp' => $this->hp
                    ];
                }
                return $result;
            case 'right':
                $result = array();
                if ($this->x < count($map) - 1) {
                    $x = $this->x + 1;
                    $y = $this->y;
                    if (!($map[$x][$y]->passability)) {     // проверяем можно ли пройти
                        if (!(get_class($map[$x][$y]) === 'Water')) {   // если не вода, то бьем объект на карте
                            if ($this->right_hand && $this->right_hand->type === 'weapon') {
                                $map[$x][$y]->hit($this->right_hand->damage);
                                $this->right_hand->hit(1);
                                $result[] = (object) [
                                    'type' => 'item',
                                    'id' => $this->right_hand->id,
                                    'hp' => $this->right_hand->hp
                                ];
                            } else {
                                $map[$x][$y]->hit(1);
                                $this->hit(1);
                            }
                            $result[] = (object)[
                                'type' => 'tile',
                                'id' => $map[$x][$y]->id,
                                'hp' => $map[$x][$y]->hp
                            ];
                        }
                    }
                    $result[] = (object)[
                        'type' => 'human',
                        'id' => $this->id,
                        'x' => $x,
                        'hp' => $this->hp
                    ];
                }
                return $result;
            case 'up':
                $result = array();
                if ($this->y > 0) {
                    $x = $this->x;
                    $y = $this->y - 1;
                    if (!($map[$x][$y]->passability)) {
                        if (!(get_class($map[$x][$y]) === 'Water')) {
                            if ($this->right_hand && $this->right_hand->type === 'weapon') {
                                $map[$x][$y]->hit($this->right_hand->damage);
                                $this->right_hand->hit(1);
                                $result[] = (object) [
                                    'type' => 'item',
                                    'id' => $this->right_hand->id,
                                    'hp' => $this->right_hand->hp
                                ];
                            } else {
                                $map[$x][$y]->hit(1);
                                $this->hit(1);
                            }
                            $result[] = (object) [
                                'type' => 'tile',
                                'id' => $map[$x][$y]->id,
                                'hp' => $map[$x][$y]->hp
                            ];
                        }
                    }
                    $result[] = (object) [
                        'type' => 'human',
                        'id' => $this->id,
                        'y' => $y,
                        'hp' => $this->hp
                    ];
                }
                return $result;
            case 'down':
                $result = array();
                if ($this->y < count($map[0]) - 1) {
                    $x = $this->x;
                    $y = $this->y + 1;
                    if (!($map[$x][$y]->passability)) {     // проверяем можно ли пройти
                        if (!(get_class($map[$x][$y]) === 'Water')) {   // если не вода, то бьем объект на карте
                            if ($this->right_hand && $this->right_hand->type === 'weapon') {
                                $map[$x][$y]->hit($this->right_hand->damage);
                                $this->right_hand->hit(1);
                                $result[] = (object) [
                                    'type' => 'item',
                                    'id' => $this->right_hand->id,
                                    'hp' => $this->right_hand->hp
                                ];
                            } else {
                                $map[$x][$y]->hit(1);
                                $this->hit(1);
                            }
                            $result[] = (object) [
                                'type' => 'tile',
                                'id' => $map[$x][$y]->id,
                                'hp' => $map[$x][$y]->hp
                            ];
                        }
                    }
                    $result[] = (object) [
                        'type' => 'human',
                        'id' => $this->id,
                        'y' => $y,
                        'hp' => $this->hp
                    ];
                }
                return $result;
        }
        return false;
    }

    public function takeItem($itemId) {
        if ($this->right_hand && $this->left_hand && $this->backpack) {
            return false;
        }
        if ($this->right_hand && $this->left_hand) {
            $this->backpack = $this->right_hand;
            $this->right_hand = $itemId;
            return true;
        }
        if ($this->right_hand) {
            $this->left_hand = $itemId;
            return true;
        }
        $this->right_hand = $itemId;
        return true;
    }

    public function dropItem($hand) {
        // для проверки
        //$this->right_hand = (object) ['id' => 1];
        if ($hand === 'right') {
            return $this->right_hand;
        } elseif ($hand === 'left') {
            return $this->left_hand;
        }
        return false;
    }

    public function putOn() {
        // для проверки
        //$this->right_hand = (object) ['type' => 'clothes'];
        if($this->right_hand->type === 'clothes') {    // переделать clothes
            $this->body = $this->right_hand;
            $this->right_hand = null;
            return true;
        } elseif ($this->left_hand->type === 'clothes') {
            $this->body = $this->left_hand;
            $this->left_hand = null;
            return true;
        }
        return false;
    }

    public function putOnBackpack() {
        // для проверки
        //$this->right_hand = new stdClass();
        if($this->right_hand) {
            $this->backpack = $this->right_hand;
            $this->right_hand = null;
            return true;
        } elseif ($this->left_hand) {
            $this->backpack = $this->left_hand;
            $this->left_hand = null;
            return true;
        }
        return false;
    }

    public function shot() {
        // ???
    }

    public function rapair() {
        if ($this->right_hand->type === 'weapon' && $this->right_hand->type === 'resource') { // переделать resource
            $resourceCount = $this->left_hand->count; // сохраняем количество ресурсов
            $this->left_hand = null; // удаляем ресурс из левой руки
            return ['id' => $this->right_hand,          // возвращаем id предмета и кол-во ресурсов
                    'count' => $this->left_hand->count
            ];
        }
    }

    public function fix() {

    }

    public function eat() {
        // для проверки
        //$this->right_hand = (object) ['type' => 'food'];
        if($this->right_hand->type === 'food') {
            $this->satiety += $this->left_hand->count;
            $this->right_hand = null;
            return true;
        } elseif ($this->left_hand->type === 'food') {
            $this->satiety += $this->left_hand->count;
            $this->left_hand = null;
            return true;
        }
        return false;
    }

}
