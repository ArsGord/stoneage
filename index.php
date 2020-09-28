<?php

require_once "../Heroes_of_VM-21_Stone_Age/application/game/entities/Entity.php";
require_once "../Heroes_of_VM-21_Stone_Age/application/game/entities/units/Animal.php";
require_once "../Heroes_of_VM-21_Stone_Age/application/game/entities/units/Human.php";

$human = new Human(new stdClass());
print_r($human);