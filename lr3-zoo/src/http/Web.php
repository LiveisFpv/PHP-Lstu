<?php

    namespace src\http;

    use src\http\Router;
    use src\controllers\AnimalController;

    $router = new Router();
    
    $animals = new AnimalController();
    $router->get('/animals', [$animals, 'index']);
    $router->post('/animals/create', [$animals, 'create']);

    $router->resolve();
?>