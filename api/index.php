<?php
//header('Content-Type: application/json; charset= UTF-8');
header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
//header('Access-Control-Allow-Headers: Content-Type');
//header('Access-Control-Allow-Credentials: true');

error_reporting(1);

// ИМПОРТ ФАЙЛОВ
require_once "application/Application.php";

function router($params) {
    $method = $params['method'];
    if ($method) {
        $app = new Application();
        switch ($method) {
            // user
            case 'login': return $app->login($params);
            case 'logout': return $app->logout($params);
            case 'registration': return $app->registration($params);
            // game
            case 'move': return $app->move($params);
            case 'takeItem': return $app->takeItem($params);
            case 'dropItem': return $app->dropItem($params);
            case 'putOn': return $app->putOn($params);
            case 'putOnBackpack': return $app->putOnBackpack($params);
            case 'repair': return $app->repair($params);
            case 'fix': return $app->fix($params);
            case 'eat': return $app->eat($params);
            case 'makeItem': return $app->makeItem($params);
            case 'makeBuilding': return $app->makeBuilding($params);
            case 'keepBuilding': return $app->keepBuilding($params);
            case 'getMap': return $app->getMap($params);
            case 'updateMap': return $app->updateMap($params);
            case 'changeHash': return $app->changeHash($params);
            case 'getGamers': return $app->getGamers($params);
            case 'getGamer': return $app->getGamer($params);
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