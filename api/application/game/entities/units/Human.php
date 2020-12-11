<?php

class Human extends Animal {
    function __construct($data) {
        parent::__construct($data);
        $this->body = $data->body;
        $this->left_hand = $data->left_hand;
        $this->right_hand = $data->right_hand;
        $this->backpack = $data->backpack;
        $this->protection = $data->protection;
        $this->user_id = $data->user_id;
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

    private function canMove($x, $y, $tiles, $width, $height) {
        $result = [];
        if ($x >= 0 && $y >= 0 && $x <= $width - 1 && $y <= $height - 1) { // проверка на границу карты
            for ($i = 0; $i < count($tiles); $i++) {
                if ($tiles[$i]->x == $x && $tiles[$i]->y == $y) {
                    $tile = $tiles[$i];
                    break;
                }
            }
            if ((int)$tile->type === 0) {     // проверяем можно ли пройти
                if ($tile->name !== 'water') {
                    if ($this->right_hand->damage) {
                        $tile->hit($this->right_hand->damage);
                        $this->right_hand->hit(1); // уменьшение прочности оружия
                        $result[] = [
                            'type' => 'item',
                            'id' => $this->right_hand->id,
                            'hp' => $this->right_hand->hp
                        ];
                    } else {
                        $tile->hit(1);
                        $this->hit(1);
                    }
                    $result[] = [
                        'type' => 'tile',
                        'id' => $tile->id,
                        'hp' => $tile->hp
                    ];
                } else {
                    $x = $this->x;
                    $y = $this->y;
                }
            }
        } else {
            $x = $this->x;
            $y = $this->y;
        }
        $result[] = [
            'type' => 'human',
            'id' => $this->id,
            'x' => $x,
            'y' => $y,
            'hp' => $this->hp
        ];
        return $result;
    }

    public function move($map, $direction) {
        // взять непроходимые предметы на карте
        // выбираем непроходимые объекты на карте
        $tiles = $map['tiles'];
        $width = $map['map']->width;
        $height = $map['map']->height;
        switch ($direction) {
            case 'left':
                $x = $this->x - 1;
                $y = $this->y;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
            case 'right':
                $x = $this->x + 1;
                $y = $this->y;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
            case 'up':
                $x = $this->x;
                $y = $this->y - 1;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
            case 'down':
                $x = $this->x;
                $y = $this->y + 1;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
            case 'leftUp':
                $x = $this->x - 1;
                $y = $this->y - 1;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
            case 'rightUp':
                $x = $this->x + 1;
                $y = $this->y - 1;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
            case 'leftDown':
                $x = $this->x - 1;
                $y = $this->y + 1;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
            case 'rightDown':
                $x = $this->x + 1;
                $y = $this->y + 1;
                return $this->canMove($x, $y, $tiles, $width, $height);
                break;
        }
        return false;
    }

    public function takeItem($item) {
        if ($this->right_hand && $this->left_hand && $this->backpack && $this->body) {
            return false;
        }
        if ($this->right_hand && $this->left_hand) {
            $this->backpack = $this->right_hand;
            $this->right_hand = $item;
            return true;
        }
        if ($this->right_hand) {
            $this->left_hand = $item;
            return true;
        }
        $this->right_hand = $item;
        return [
            'right_hand' => $this->right_hand,
            'left_hand' => $this->left_hand,
            'backpack' => $this->backpack
            //'body' => $this->body
        ];
    }

    public function dropItem() {
        return $this->right_hand;
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
        if($this->right_hand) {
            return [
                'right_hand' => $this->backpack,
                'left_hand' => $this->left_hand,
                'backpack' =>  $this->right_hand
            ];
        } elseif ($this->left_hand) {
            return [
                'right_hand' => $this->right_hand,
                'left_hand' => $this->backpack,
                'backpack' => $this->left_hand
            ];
        }
        return false;
    }

    public function shot() {
        // ???
    }

    public function repair() {
        // для проверки
        //$this->right_hand = (object) ['type' => 'weapon'];
        //$this->left_hand = (object) ['type' => 'resource'];
        if ($this->right_hand->type === 'weapon' && $this->left_hand->type === 'resource') {
            return [
                'itemId' => $this->right_hand,  // возвращаем id предмета и ресурса
                'resourceId' => $this->left_hand
            ];
        }
    }

    public function fix() {

    }

    public function eat() {
        // для проверки
        //$this->right_hand = (object) ['type' => 'food'];
        if($this->right_hand->type === 'food') {
            return $this->right_hand;
        } elseif ($this->left_hand->type === 'food') {
            return $this->left_hand;
        }
        return false;
    }

    public function makeItem() {
        return true;
    }

    public function makeBuilding($userId) {

    }

    public function keepBuilding($userId, $buildingId) {

    }
}
