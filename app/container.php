<?php
$container = $app->getContainer();

$container['view'] = function ($c) {
    $dir = __DIR__.'/Views';
    $view = new \Slim\Views\Twig($dir, [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['ovh'] = function () {
    $applicationKey = getenv('APPLICATION_KEY');
    $applicationSecret = getenv('APPLICATION_SECRET');
    $endpoint = getenv('ENDPOINT');
    return new \Ovh\Api($applicationKey, $applicationSecret, $endpoint, $_SESSION['consumer_key']);
};