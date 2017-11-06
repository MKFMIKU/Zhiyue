<?php
/**
 * Created by PhpStorm.
 * User: meikangfu
 * Date: 2017/11/4
 * Time: 下午8:28
 */

require '../vendor/autoload.php';
$config = require __DIR__ . '/config.php';

session_start();

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('Zhiyue');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['notFoundHandler'] = function ($request, \Slim\Http\Response $response) {
    return $response
        ->withStatus(404)
        ->withHeader('Content-type', 'application/json')
        ->write(json_encode([
            'code' => '404',
            'msg' => 'Not Found URL'
        ]));
};

$container['errorHandler'] = function ($request, \Slim\Http\Response $response, Exception $exception) {
    return $response
        ->withStatus(500)
        ->write(json_encode([
            'code' => '500',
            'msg' => 'Server Error',
            'trace' => $exception->getTrace()
        ]));
};

$routers = glob('routers/*.router.php');
foreach ($routers as $router) {
    require $router;
}

$app->run();