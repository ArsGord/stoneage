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
            $result = $human->move($map, $direction);
            if ($result) { // обновить данные в БД
                //... поменять даные в БД
                $res = [];
                foreach ($result as $key => $val) {
                    switch ($result[$key]['type']) {
                        case 'human':
                            $result = $result[0];
                            foreach ($result as $key => $val) {
                                if ((int)$result[$key] !== (int)$human->$key && $key !== 'type') {
                                    $res[$key] = $result[$key];
                                }
                            }
                            if (count($res) > 0) {
                                $this->db->updateGamer($res, $human->id);
                            }
                            break;
                        case 'tile':
                            break;
                        case 'item':
                            break;
                    }
                }
                $this->db->changeHash();
                return $res;
            }
        }
        return false;
    }

    // поднять предмет
    public function takeItem($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        foreach ($this->db->getFreeItems() as $item) {
            if ($item->x === $human->x && $item->y === $human->y) { //проверяем координаты предметов
                if ($human->takeItem($item->id)) { //берём предмет с земли
                    $this->db->takeItem($human->id, $item->id); //удаляем с карты
                    $this->db->updateInventory($human->id);
                    return true;
                }
            }
        }
        return false;
    }

    // бросить предмет
    public function dropItem($userId, $hand = 'right') {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            $itemId = $human->dropItem($hand);
        }
        if ($itemId) {
            $this->db->dropItem($itemId); // выбрасываем предмет
            return true;
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
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            return $human->putOnBackpack();
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
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            $itemId = $human->eat();
            $item = $this->db->getItemById($itemId);
        }
        if ($item) {
            $human->satiety += $item->calories; // добавляем сытость
            $item->count--; // уменьшаем кол-во еды
            if ($item->count <= 0) {
                $item = null;
            }
            // обновить в БД
            return true;
        }
        return false;
    }

    // сделать предмет
    public function makeItem($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            $human->makeItem();
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
    // обновить игровое окружение
        // (проголодать всех живых существ, умереть голодных,
        // сходить коровками, вырасти травку, сменить время суток, протухнуть еду)
    // вернуть слова игроков, которых я слышу
}
