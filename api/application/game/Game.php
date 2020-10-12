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
                new Tree(new stdClass()),
                new Rock(new stdClass()),
                new Grass(new stdClass())
            ),
            array(
                new Plant(new stdClass()),
                new Grass(new stdClass()),
                new Rock(new stdClass())
            ),
            array(
                new Tree(new stdClass()),
                new Grass(new stdClass()),
                new Grass(new stdClass())
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
    public function takeItem($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        foreach ($this->db->getFreeItems() as $item) {
            if ($item->x === $human->x && $item->y === $human->y) { //проверяем координаты предметов
                if ($human->takeItem($item->id)) { //берём предмет с земли
                    $this->db->takeItem($human->id, $item->id); //удаляем с карты
                    $this->db->updateInventory($human);
                    return true;
                }
            }
        }
        return false;
    }

    // бросить предмет
    public function dropItem($userId, $hand = 'right') {
        $human = new Human($this->db->getHumanByUserId($userId));
        $itemId = $human->dropItem($hand);
        if ($itemId) {
            $this->db->dropItem($itemId); // выбрасываем предмет
            return true;
        }
        return false;
    }

    // надеть предмет
    public function putOn($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        return $human->putOn();
    }
    // положить предмет в карман
    public function putOnBackpack($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        return $human->putOnBackpack();
    }

    // выстрелить/бросить (копье или не копье)
    public function shot($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
    }

    // положить предмет в (?)
    // починить то, что в руках/надето/лежит в кармане
    public function repair($userId) {

    }
    // починить то, что лежит/стоит (строение)
    public  function fix($userId, $buildingId) {

    }
    // поесть
    public function eat($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($human) {
            return $human->eat();
        }
    }
    // сделать предмет
    public function makeItem($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));

    }
    // сделать строение
    public function makeBuilding($userId) {

    }
    // продолжить строить строение
    public function keepBuilding($userId, $buildingId) {

    }
    // обновить игровое окружение
        // (проголодать всех живых существ, умереть голодных,
        // сходить коровками, вырасти травку, сменить время суток, протухнуть еду)
    // вернуть слова игроков, которых я слышу
}