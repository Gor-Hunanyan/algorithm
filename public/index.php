<?php


require dirname(__DIR__) . '/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Doctrine\ORM\EntityManager;


$request = Request::createFromGlobals();

$context = new \Symfony\Component\Routing\RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);


try {
    $parameters = $matcher->match($request->getPathInfo());
    $controller = new $parameters["_controller"];

    $f = new ReflectionMethod($parameters["_controller"], $parameters["_action"]);
    $params = [];
    foreach ($f->getParameters() as $param) {
        if ($param->hasType()){
            switch ($param->getType()->getName()){
                case Request::class:
                    $params[] = $request;
                    break;
                case EntityManager::class:
                    $params[] = $entityManager;
                    break;
            }
        }
        else {
            $params[] = $parameters[$param->name] ?? null;
        }
    }

    $controller = new $parameters["_controller"];
    $response = call_user_func_array([$controller, $parameters["_action"]], $params);
}
catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $e){
    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->setStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
}

$response->send();
