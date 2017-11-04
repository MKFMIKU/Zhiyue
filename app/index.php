<?php
/**
 * Created by PhpStorm.
 * User: meikangfu
 * Date: 2017/11/4
 * Time: 下午8:28
 */

require '../vendor/autoload.php';
require 'configs/dev.config.php';

session_start();

$app = new \Slim\App();

$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('Zhiyue');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$app->get('/status', function ($request, $response, $args) {
    $response = $response->withStatus(200)->withHeader('Content-type', 'application/json');
    return $response->write(json_encode([
        'code' => '200',
        'msg' => 'ok'
    ]));
});

$routers = glob('routers/*.router.php');
foreach ($routers as $router) {
    require $router;
}

$app->run();