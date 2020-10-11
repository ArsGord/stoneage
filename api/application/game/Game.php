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
                new Tree(new stdClass()), new Rock(new stdClass()), new Grass(new stdClass())
            ),
            array(
                new Plant(new stdClass()), new Grass(new stdClass()), new Rock(new stdClass())
            ),
            array(
                new Tree(new stdClass()), new Grass(new stdClass()), new Grass(new stdClass())
            )
        );
    }

    public function test($entity) {
        // если сущность-класс с таким названием есть, то
        // создать её экземпляр и вернуть его
        // иначе вернуть false
        foreach (get_declared_classes() as $value) {
            if ($entity === $value) {
                $ENTITY = new $entity(new stdClass());
                return $ENTITY;
            }
        }
        return false;
    }

    // войти в игру (создать персонажа, подгрузить персонажа)
    // выйти из игры
    // умерерть игорька (если он помер)

    // сделать шаг
    // http://stoneage/api/?method=move&token=123&direction=left
    public function move($userId, $direction) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($userId && $direction) {
            // проверить, что direction нормальный
            $canMove = $human->move($this->map, $direction);

            switch ($direction) {
                case 'left':
                    $X = $human->x - 1;
                    $Y = $human->y;
                    $result = $this->checkMove($X, $Y, $canMove, $human);
                    $human = $result->human;
                    return $result->flag;
                case 'right':
                    $X = $human->x + 1;
                    $Y = $human->y;
                    $result = $this->checkMove($X, $Y, $canMove, $human);
                    $human = $result->human;
                    return $result->flag;
                case 'up':
                    $X = $human->x;
                    $Y = $human->y - 1;
                    $result = $this->checkMove($X, $Y, $canMove, $human);
                    $human = $result->human;
                    return $result->flag;
                case 'down':
                    $X = $human->x;
                    $Y = $human->y + 1;
                    $result = $this->checkMove($X, $Y, $canMove, $human);
                    $human = $result->human;
                    return $result->flag;
            }
        }
    }
    // для функции move
    private function checkMove($X, $Y, $canMove, $human) {
        if ($canMove) {
            // ищем игрока в базе данных, если нашелся, то бьем его
            foreach ($this->db->users as $user) {
                if ($user->x === $X && $user->y === $Y) {
                    if ($human->right_hand->damage) { // проверяем урон human
                        $user->hit($human->right_hand->gamage);
                    } else {
                        $user->hit(1);
                    }
                    $userFinded = true;
                    break;
                } else {
                    $userFinded = false;
                }
            }
            // если игрок не найден, то передвигаемся
            if (!$userFinded) {
                $human->x = $X;
            }
            return (object) [
                'human' => $human,
                'flag' => true
            ];
        } else {
            if (get_class($this->map[$X][$Y]) !== 'Water') { // если вода, то никуда не идем
                // нанести урон объекту на карте
                if ($human->right_hand->damage) {
                    $this->map[$X][$Y]->hit($this->right_hand->damage);
                } else {
                    $this->map[$X][$Y]->hit(1);
                }
            }
            return (object) [
                'human' => $human,
                'flag' => true
            ];
        }
    }

    // поднять предмет
    public function takeItem($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        foreach ($this->db->items as $item) {
            if ($item->x === $human->x && $item->y === $human->y) { //проверяем координаты предметов
                $human->takeItem($item);                            //берём предмет с земли
                $this->db->item->delete($item->id);                 //удаляем с карты
            }
        }
    }
    // бросить предмет
    public function dropItem($userId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        $item = $human->dropItem();
        if ($item) {
            $this->db->items[] = $item;                             //выбрасываем предмет
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
    // ударить
    public function hit($userId, $direction) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($userId && $direction) {

        }
    }
    // положить предмет в (?)
    // починить то, что в руках/надето/лежит в кармане
    public function repair($userId, $itemId) {

    }
    // починить то, что лежит/стоит (строение)
    public  function fix($userId, $buildingId) {

    }
    // поесть
    public function eat($userId, $itemId) {
        $human = new Human($this->db->getHumanByUserId($userId));
        if ($userId && $itemId) {
            return $human->eat($itemId);
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