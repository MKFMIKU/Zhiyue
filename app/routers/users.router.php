<?php
/**
 * Created by PhpStorm.
 * User: meikangfu
 * Date: 2017/11/5
 * Time: 上午12:57
 */

use models\User;

$app->post('/user', function () use ($app) {
    $user = json_decode($app->request()->getBody());
    $user['password'] = hash("sha1", $user['pass']);
    $oUser = new User();
    echo json_encode($oUser->insert($user));
});