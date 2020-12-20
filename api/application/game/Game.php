<?php

// entity
require_once "entities/Entity.php";
// buildings
require_once "entities/buildings/Hut.php";
require_once "entities/buildings/Wall.php";
// items
require_once "entities/items/Weapon.php";
require_once "entities/items/Arrow.php";
require_once "entities/items/Axe.php";
require_once "entities/items/Bow.php";
require_once "entities/items/Clothes.php";
require_once "entities/items/Food.php";
require_once "entities/items/Shield.php";
require_once "entities/items/Spear.php";
require_once "entities/items/Stone.php";
require_once "entities/items/Wood.php";
// tiles
require_once "entities/tiles/Plant.php";
require_once "entities/tiles/Grass.php";
require_once "entities/tiles/Rock.php";
require_once "entities/tiles/Tree.php";
// units
require_once "entities/units/Animal.php";
require_once "entities/units/Human.php";
require_once "entities/units/Cow.php";


class Game {
    function __construct($db) {
        $this->db = $db;
    }
    // войти в игру (создать персонажа, подгрузить персонажа)
    // выйти из игры
    // умерерть игорька (если он помер)

    // сделать шаг
    public function move($userId, $direction) {
        $map = $this->getMap();
        $gamers = $map['gamers'];
        $humans = array();
        $human = null;
        foreach ($gamers as $key => $gamer) {
            $humans[] = new Human($gamer);
            if (intval($gamer->user_id) === intval($userId)) {
                $human = $humans[$key];
            }
        }
        if ($human) {
            $result = $human->move($map, $direction, $humans);
            if ($result) { // обновить данные в БД
                //... поменять даные в БД
                foreach ($result as $key => $val) {
                    switch ($result[$key]['type']) {
                        case 'human':
                            unset($val['type']); // убираем свойство type из объекта
                            $this->db->updateGamer($val, $val['id']);
                            break;
                        case 'tile':
                            break;
                        case 'item':
                            break;
                    }
                }
                $this->db->changeHash();
                return true;
            }
        }
        return false;
    }

    // поднять предмет
    public function takeItem($userId) {
        $human = new Human($this->db->getGamer($userId));
        if (!$human->right_hand || !$human->left_hand || !$human->backpack) {
            foreach ($this->db->getItems() as $item) {
                if ($item->x === $human->x && $item->y === $human->y) { //проверяем координаты предметов
                    $items = $human->takeItem($item);
                    $this->db->takeItem($human->id, $items); //удаляем с карты
                    $this->db->changeHash();
                    return true;
                    }
                }
            }
        return false;
    }

    // бросить предмет
    public function dropItem($userId/*, $hand = 'right'*/) {
        $human = new Human($this->db->getGamer($userId));
        if ($human->right_hand) {
            $canDrop = true;
            foreach ($this->db->getItems() as $item) { // проверяем, лежит ли под нами другой предмет
                if ($human->x === $item->x && $human->y === $item->y) {
                    $canDrop = false;
                    break;
                }
            }
            if ($canDrop) {
                $this->db->dropItem($human->right_hand, $human->x, $human->y);
                $this->db->changeHash();
                return true;
            }
        }
        return false;
    }

    // надеть предмет
    public function putOn($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            return $human->putOn();
        }
        return false;
    }
    // положить предмет в карман
    public function putOnBackpack($userId) {
        $human = new Human($this->db->getGamer($userId));
        $items = $human->putOnBackpack();
        if ($human && $items) {
            $this->db->putOnBackpack($items);
            return true;
        }
        return false;
    }

    // выстрелить/бросить (копье или не копье)
    public function shot($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            $human->shot();
            return true;
        }
        return false;
    }

    // положить предмет в (?)
    // починить то, что в руках/надето/лежит в кармане
    public function repair($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            $arr = $human->repair();
        }
        if ($arr) {
            $weapon = $this->db->getItemById($arr->itemId);
            $resource = $this->db->getItemById($arr->resourceId);
        }
        if ($weapon && $resource) {
            $weapon->hp += $resource->value;
            $resource->count--;
            if ($resource->count <= 0) {
                $resource = null;
            }
            // обновить в БД
            $this->db->updateInventory();
            return true;
        }
        return false;
    }

    // починить то, что лежит/стоит (строение)
    public  function fix($userId, $buildingId) {
        $human = new Human($this->db->gerHumanByUserId($userId));
    }

    // поесть
    public function eat($userId) {
        $human = new Human($this->db->getGamer($userId));
        if ($human) {
            $result = $human->eat();
            if ($result) {
                foreach ($result as $key => $val) {
                    switch ($val['type']) {
                        case 'human':
                            unset($result[$key]['type']);
                            $this->db->updateGamer($result[$key], $human->id);
                        case 'food':
                            if ((int)$result[$key]['count'] === 0) {
                                $this->db->deleteItem($result[$key]['id']);
                            } else {
                                unset($result[$key]['type']);
                                $this->db->updateItem($result[$key], $result[$key]['id']);
                            }
                    }
                }
                return true;
            }
        }
        return false;
    }

    // сделать предмет
    public function makeItem($userId) {
        $human = new Human($this->db->getGamer($userId));
        if ($human) {
            $result = $human->makeItem();
            if ($result) {
                foreach ($result as $key => $val) {
                    switch ($val['type']) {
                        case 'delete':
                            $this->db->deleteItem($val['id']);
                            break;
                        case 'create':
                            $item = $this->db->getDefaultItemById($val['type_id']); // берем предмет из БД
                            // переименование свойств объекта
                            $item->hp = $item->default_hp;
                            $item->type_id = $item->id;
                            unset($item->default_hp, $item->type, $item->id);
                            $item->gamer_id = $human->id;
                            $item->inventory = 'right_hand';
                            foreach ($item as $key => $val) {
                                if (!$val) {
                                    $item->$key = 'NULL';
                                }
                            }
                            return $this->db->createItem($item);
                    }
                }
            }
        }
        return false;
    }

    // сделать строение
    public function makeBuilding($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            return $human->makeBuilding($userId);
        }
        return false;
    }

    // продолжить строить строение
    public function keepBuilding($userId, $buildingId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            return $human->keepBuilding($userId, $buildingId);
        }
    }

    public function getMap() {
        $map = $this->db->getMap();
        $array = explode(',', $map->field);
        $arrMap = [];
        for ($i = 1; $i <= count($array); $i++) {
            $arr[] = (int)$array[$i - 1];
            if ($i % (int)$map->width === 0) {
                $arrMap[] = $arr;
                $arr = [];
            }
        }
        $map->field = $arrMap;
        return array (
            'tiles' => $this->getTiles(),
            'map' => $map,
            'gamers' => $this->getGamers(),
            'items' => $this->db->getItems()
        );
    }

    public function updateMap($hash) {
        return $this->db->updateMap($hash);
    }

    public function join($userId) {
        //взять игрока
        //если игрок не взялся, то создать его
        //изменить хэш в maps
        $gamer = $this->getGamer($userId);
        if ($gamer) {
            $this->db->setStatusOnline($userId);
            $this->changeHash();
            return $gamer;
        } else {
            $this->db->setStatusOnline($userId);
            $this->changeHash();
            $gamer = $this->db->createGamer($userId);
            return $gamer;
        }
    }

    public function leave($userId) {
        $this->changeHash();
        return $this->db->leave($userId);
    }

    public function changeHash() {
        return $this->db->changeHash();
    }

    public function getGamer ($gamerId) {
        $human = $this->db->getGamer($gamerId);
        if ($human) {
            return new Human($human);
        } else {
            return false;
        }
    }

    public function getGamers () {
        $gamers = $this->db->getGamers();
        $Gamers = [];
        foreach ($gamers as $key => $val) {
            $Gamers[] = new Human($gamers[$key]);
        }
        return $Gamers;
    }

    public function getTiles () {
        $tiles = $this->db->getTiles();
        $Tiles = [];
        foreach ($tiles as $key => $val) {
            $Tiles[] = new Entity($tiles[$key]);
        }
        return $Tiles;
    }

    /*public function fillMap() {
        $tile = [];
        $map = $this->db->getMap();
        $sizes = [
            'width' => (int)$map->width,
            'height' => (int)$map->height
        ];
        for ($i = 40; $i < 50; $i++) { // y (высота)
            for ($j = 0; $j < $sizes['width']; $j++) { // x (ширина)
                switch (rand(1, 5)) {
                    case 1:
                        $tile = (object) [
                            'type' => 1,
                            'name' => 'dirt',
                            'x' => $j,
                            'y' => $i
                        ];
                        $this->db->addTile($tile);
                        break;
                    case 2:
                        $tile = (object) [
                            'type' => 1,
                            'name' => 'grass',
                            'x' => $j,
                            'y' => $i
                        ];
                        $this->db->addTile($tile);
                        break;
                    case 3:
                        $tile = (object) [
                            'type' => 1,
                            'name' => 'snow',
                            'x' => $j,
                            'y' => $i
                        ];
                        $this->db->addTile($tile);
                        break;
                    case 4:
                        $tile = (object) [
                            'type' => 1,
                            'name' => 'sand',
                            'x' => $j,
                            'y' => $i
                        ];
                        $this->db->addTile($tile);
                        break;
                    case 5:
                        $tile = (object) [
                            'type' => 0,
                            'name' => 'water',
                            'x' => $j,
                            'y' => $i
                        ];
                        $this->db->addTile($tile);
                        break;
                }
            }
        }
        return true;
    }*/
    // обновить игровое окружение
        // (проголодать всех живых существ, умереть голодных,
        // сходить коровками, вырасти травку, сменить время суток, протухнуть еду)
    // вернуть слова игроков, которых я слышу
}
