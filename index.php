<?php

error_reporting(-1);

// ИМПОРТ ФАЙЛОВ
require_once "application/Application.php";
// entity
require_once "application/game/entities/Entity.php";
// buildings
require_once "application/game/entities/buildings/Hut.php";
require_once "application/game/entities/buildings/Wall.php";
// items
require_once "application/game/entities/items/Weapon.php";
require_once "application/game/entities/items/Arrow.php";
require_once "application/game/entities/items/Axe.php";
require_once "application/game/entities/items/Bow.php";
require_once "application/game/entities/items/Clothes.php";
require_once "application/game/entities/items/Food.php";
require_once "application/game/entities/items/Shield.php";
require_once "application/game/entities/items/Spear.php";
require_once "application/game/entities/items/Stone.php";
require_once "application/game/entities/items/Wood.php";
// tiles
require_once "application/game/entities/tiles/Plant.php";
require_once "application/game/entities/tiles/Grass.php";
require_once "application/game/entities/tiles/Rock.php";
require_once "application/game/entities/tiles/Tree.php";
// units
require_once "application/game/entities/units/Animal.php";
require_once "application/game/entities/units/Human.php";
require_once "application/game/entities/units/Cow.php";

function router($params) {
    $method = $params['methods'];
    if ($method) {
        $app = new Application();
        switch ($method) {
            case 'login': return $app->login($params);
            // ..
        }
    }
    return false;
}

function answer($data) {
    if ($data) {
        return array(
            'result' => 'ok',
            'data' => $data
        );
    }
    return array(
        'result' => 'error'
    );
}

echo json_encode(answer(router($_GET)));

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

// ВЫВОД НА ЭКРАН
// buildings
print_r($hut);
print_r("<br>");
print_r($wall);
print_r("<br>");
// items
print_r($arrow);
print_r("<br>");
print_r($axe);
print_r("<br>");
print_r($bow);
print_r("<br>");
print_r($clothes);
print_r("<br>");
print_r($food);
print_r("<br>");
print_r($shield);
print_r("<br>");
print_r($spear);
print_r("<br>");
print_r($stone);
print_r("<br>");
print_r($weapon);
print_r("<br>");
print_r($wood);
print_r("<br>");
// tiles
print_r($grass);
print_r("<br>");
print_r($plant);
print_r("<br>");
print_r($rock);
print_r("<br>");
print_r($tree);
print_r("<br>");
// units
print_r($animal);
print_r("<br>");
print_r($cow);
print_r("<br>");
print_r($human);
print_r("<br>");

print_r($entity);
print_r("<br>");
