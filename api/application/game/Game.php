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

    function __construct() {
        /*
        // ПРОВЕРКА КЛАССОВ
        $entity = new Entity(new stdClass());
        // buildings
        $hut = new Hut(new stdClass());
        $wall = new Wall(new stdClass());
        // items
        $arrow = new Arrow(new stdClass());
        $axe = new Axe(new stdClass());
        $bow = new Bow(new stdClass());
        $clothes = new Clothes(new stdClass());
        $food = new Food(new stdClass());
        $shield = new Shield(new stdClass());
        $spear = new Spear(new stdClass());
        $stone = new Stone(new stdClass());
        $weapon = new Weapon(new stdClass());
        $wood = new Wood(new stdClass());
        // tiles
        $grass = new Grass(new stdClass());
        $plant = new Plant(new stdClass());
        $rock = new Rock(new stdClass());
        $tree = new Tree(new stdClass());
        // units
        $animal = new Animal(new stdClass());
        $cow = new Cow(new stdClass());
        $human = new Human(new stdClass());
        */
    }

    public function test($entity) {
        // если сущность-класс с таким названием есть, то
        // создать её экземпляр и вернуть его
        // иначе вернуть false
    }
        //войти в игру(создать персонажа, подгрузить персонажа)
        //выйти из игры
        //умереть игорька(если он умер)
        //сделать шаг
        public function move($userId, $direction) {
            $human = $this -> $db -> getHumanByUserId($userId);
            if($human && $direction) {
                //взять карту
                //взять непроходимые предметы на карте
                //взять юниты
                //сходить
            }
        }
        //поднять предмет
        //бросить предмет
        //надеть предмет
        //положить предмет в карман
        //ударить
        //положить предмет в (?)
        //починить то, что в руках/надето/лежит в кармане
        //починить то, что лежит/стоит(строение)
        //поесть
        //сделать предмет
        //сделать строение
        //продолжить строить строение
        //обновить игровое окружение
        //сходить коровками вырасти траву
        //вернуть список игроков которых я слышу
}