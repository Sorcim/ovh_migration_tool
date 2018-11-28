<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;

class AbstractController {
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function render(ResponseInterface $response, $file, $args = [])
    {
        $this->container->view->render($response, $file, $args);
    }

    public function __get($name)
    {
        return $this->container->get($name);
    }
}