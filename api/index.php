<?php

error_reporting(1);

// ИМПОРТ ФАЙЛОВ
require_once "application/Application.php";

function router($params) {
    $method = $params['method'];
    if ($method) {
        $app = new Application();
        switch ($method) {
            // user
            //case 'login': return $app->login($params);
            case 'test': return $app->test($params);
            // game
            case 'move': return $app->move($params);
            case 'takeItem': return $app->takeItem($params);
            case 'dropItem': return $app->dropItem($params);
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