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
        $this->map = array(array(
            new Tree()
        ), array());
    }

    public function test($entity) {
        // если сущность-класс с таким названием есть, то
        // создать её экземпляр и вернуть его
        // иначе вернуть false
    }

    // войти в игру (создать персонажа, подгрузить персонажа)
    // выйти из игры
    // умерерть игорька (если он помер)

    // сделать шаг
    // http://stoneage/api/?method=move&token=123&direction=left
    public function move($userId, $direction) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($userId && $direction) {
            // првоерить, что direction нормальный
            return $human->move($this->map);
        }
    }

    // поднять предмет
    // бросить предмет
    // надеть предмет
    // положить предмет в карман
    // ударить
    // положить предмет в (?)
    // починить то, что в руках/надето/лежит в кармане
    // починить то, что лежит/стоит (строение)
    // поесть
    // сделать предмет
    // сделать строение
    // продолжить строить строение
    // обновить игровое окружение
        // (проголодать всех живых существ, умереть голодных,
        // сходить коровками, вырасти травку, сменить время суток, протухнуть еду)
    // вернуть слова игроков, которых я слышу
}