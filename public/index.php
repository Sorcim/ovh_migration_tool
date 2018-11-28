<?php

use App\Controllers\PagesControllers;

require '../vendor/autoload.php';
session_start();
$dotenv = new Dotenv\Dotenv('../');
$dotenv->load();
$app = new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true
    ]
]);

require('../app/container.php');
require('../app/middleware.php');

$app->get('/', PagesControllers::class.":index")->setName('index')->add(new OVHRequestMiddleware($app->getContainer()));
$app->post('/', PagesControllers::class.":postIndex");

$app->run();

