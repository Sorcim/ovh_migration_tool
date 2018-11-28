<?php

use Ovh\Api;
use Psr\Container\ContainerInterface;

class OVHRequestMiddleware {
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function __invoke(\Slim\Http\Request $request, \Slim\Http\Response $response, $next)
    {
        if (!isset($_SESSION['consumer_key'])){
            $redirection = $this->container->get('router')->pathFor('index');
            $rights = array( (object) [
                'method'    => 'POST',
                'path'      => '/*'
            ]);

            // Get credentials
            $conn = $this->container->get('ovh');
            $credentials = $conn->requestCredentials($rights, $redirection);

            // Save consumer key and redirect to authentication page
            $_SESSION['consumer_key'] = $credentials["consumerKey"];
            return $response->withRedirect($credentials["validationUrl"]);
        }else{
            $response = $next($request, $response);
            return $response;
        }
    }
}