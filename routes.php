<?php


use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


$routes = new RouteCollection();

$routes->add(
    "phone_books_list",
    new Route('/api/phone-books',
        ['_controller' => '\App\Controller\PhoneBookController',
         '_action' => 'listAction'],
        [],
        [],
        "",
        [],
        ["GET"]
    )
);

$routes->add(
    "get_phone_book",
    new Route('/api/phone-books/{id}',
        ['_controller' => '\App\Controller\PhoneBookController',
         '_action' => 'getAction'],
        [],
        [],
        "",
        [],
        ["GET"]
    )
);

$routes->add(
    "create_phone_book",
    new Route('/api/phone-books',
        ['_controller' => '\App\Controller\PhoneBookController',
         '_action' => 'createAction'],
        [],
        [],
        "",
        [],
        ["POST"]
    )
);

$routes->add(
    "update_phone_book",
    new Route('/api/phone-books/{id}',
        ['_controller' => '\App\Controller\PhoneBookController',
            '_action' => 'updateAction'],
        [],
        [],
        "",
        [],
        ["PUT"]
    )
);

$routes->add(
    "delete_phone_book",
    new Route('/api/phone-books/{id}',
        ['_controller' => '\App\Controller\PhoneBookController',
            '_action' => 'deleteAction'],
        [],
        [],
        "",
        [],
        ["DELETE"]
    )
);
