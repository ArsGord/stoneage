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

        // моки
        $this->map = array(
            // массив 3 на 3 из объектов карты
            array(
                new Tree((object)['id' => 1]),
                new Rock((object)['id' => 2]),
                new Grass((object)['id' => 3])
            ),
            array(
                new Plant((object)['id' => 4]),
                new Grass((object)['id' => 5]),
                new Rock((object)['id' => 6])
            ),
            array(
                new Tree((object)['id' => 7]),
                new Grass((object)['id' => 8]),
                new Grass((object)['id' => 9])
            )
        );
    }

    // войти в игру (создать персонажа, подгрузить персонажа)
    // выйти из игры
    // умерерть игорька (если он помер)

    // сделать шаг
    // http://stoneage/api/?method=move&token=123&direction=left
    public function move($userId, $direction) {
        $human = new Human($this->db->getHumanByUserId($userId));
        //$humans = $this->db->getHumans();
        $result = $human->move($this->map, /*$humans,*/ $direction);
        if ($result) { // обновить данные в БД
            //...
            return true;
        }
        return false;
    }

    // поднять предмет
    // http://stoneage/api/?method=takeItem&token=123
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
    // http://stoneage/api/?method=dropItem&token=123&hand=right
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
    // http://stoneage/api/?method=putOn&token=123
    public function putOn($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            return $human->putOn();
        }
        return false;
    }
    // положить предмет в карман
    // http://stoneage/api/?method=putOnBackpack&token=123
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
    // http://stoneage/api/?method=repair&token=123
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

        }
        return false;
    }

    // продолжить строить строение
    public function keepBuilding($userId, $buildingId) {

    }
    // обновить игровое окружение
        // (проголодать всех живых существ, умереть голодных,
        // сходить коровками, вырасти травку, сменить время суток, протухнуть еду)
    // вернуть слова игроков, которых я слышу
}