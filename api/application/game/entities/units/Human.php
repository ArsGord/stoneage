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
                    $X = $this->x - 1;
                    $Y = $this->y;
                    if (!($map[$X][$Y]->passability)) {     // проверяем можно ли пройти
                        if (!(get_class($map[$X][$Y]) === 'Water')) {   // если не вода, то бьем объект на карте
                            if ($this->right_hand && $this->right_hand->type === 'weapon') {
                                $map[$X][$Y]->hit($this->right_hand->damage);
                                $this->right_hand->hit(1);
                                $result[] = (object) [
                                    'type' => 'item',
                                    'id' => $this->right_hand->id,
                                    'hp' => $this->right_hand->hp
                                ];
                            } else {
                                $map[$X][$Y]->hit(1);
                                $this->hit(1);
                            }
                            $result[] = (object) [
                                'type' => 'tile',
                                'id' => $map[$X][$Y]->id,
                                'hp' => $map[$X][$Y]->hp
                            ];
                        }
                    }
                    $result[] = (object) [
                        'type' => 'human',
                        'id' => $this->id,
                        'x' => $this->x,
                        'hp' => $this->hp
                    ];
                }
                return $result;
            case 'right':
                if ($this->x < count($map) - 1) {
                    $X = $this->x + 1;
                    $Y = $this->y;
                    if (!($map[$X][$Y]->passability)) {
                        if (!(get_class($map[$X][$Y]) === 'Water')) {
                            if ($this->right_hand->damage) {
                                $map[$X][$Y]->hit($this->right_hand->damage);
                            } else {
                                $map[$X][$Y]->hit(1);
                            }
                        }
                    }
                }
                return (object) [
                    'result' => true,
                    'map' => $map
                ];
            case 'up':
                if ($this->y > 0) {
                    $X = $this->x;
                    $Y = $this->y - 1;
                    if (!($map[$X][$Y]->passability)) {
                        if (!(get_class($map[$X][$Y]) === 'Water')) {
                            if ($this->right_hand->damage) {
                                $map[$X][$Y]->hit($this->right_hand->damage);
                            } else {
                                $map[$X][$Y]->hit(1);
                            }
                        }
                    }
                }
                return (object) [
                    'result' => true,
                    'map' => $map
                ];
            case 'down':
                if ($this->y < count($map[0]) - 1) {
                    $X = $this->x;
                    $Y = $this->y + 1;
                    if (!($map[$X][$Y]->passability)) {
                        if (!(get_class($map[$X][$Y]) === 'Water')) {
                            if ($this->right_hand->damage) {
                                $map[$X][$Y]->hit($this->right_hand->damage);
                            } else {
                                $map[$X][$Y]->hit(1);
                            }
                        }
                    }
                }
                return (object) [
                    'result' => true,
                    'map' => $map
                ];
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
        if ($hand === 'right') {
            return $this->right_hand;
        } elseif ($hand === 'left') {
            return $this->left_hand;
        }
        return false;
    }

    public function putOn() {
        if($this->right_hand->clothes) {    // переделать clothes
            $this->body = $this->right_hand;
            $this->right_hand = null;
            return true;
        } elseif ($this->left_hand->clothes) {
            $this->body = $this->left_hand;
            $this->left_hand = null;
            return true;
        }
        return false;
    }

    public function putOnBackpack() {
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

    public function eat($eat) {
        if($this->right_hand->eat) {    // переделать eat
            $this->satiety += 10;
            $this->right_hand = null;
            return true;
        } elseif ($this->left_hand) {
            $this->satiety += 10;
            $this->left_hand = null;
            return true;
        }
        return false;
    }

}
