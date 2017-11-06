<?php
/**
 * Created by PhpStorm.
 * User: meikangfu
 * Date: 2017/11/5
 * Time: 上午12:57
 */

use models\User;
require __DIR__ . '/../models/User.php';

$app->post('/user', function ($request, $response, $args) {
    $user = json_decode($request->getBody());
    var_dump($user);
//    $user['password'] = hash("sha1", $user['pass']);
//    $oUser = new User();
//    echo json_encode($oUser->insert($user));
    echo json_encode(['msg'=>'ok']);
});