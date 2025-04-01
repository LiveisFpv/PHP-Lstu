<?php

    namespace src\http;

    use src\controllers\UserController;
    use src\http\Router;
    use src\controllers\AnimalController;
    use src\controllers\CareController;
    use src\controllers\TicketController;
    class Web{
        public function main(){
            include __DIR__ . '/../views/main.php';
        }
    }
    

    $router = new Router();
    
    $animals = new AnimalController();
    $router->get('/animals', [$animals, 'index']);
    $router->get('/animals/create', [$animals, 'form']);
    $router->post('/animals/create', [$animals, 'create']);

    $cares = new CareController();
    $router->get('/cares', [$cares,'index']);
    $router->get('/cares/create', [$cares,'form']);
    $router->post('/cares/create', [$cares,'create']);

    $users = new UserController();
    $router->get('/users', [$users,'index']);
    $router->get('/users/create', [$users,'form']);
    $router->post('/users/create', [$users,'create']);

    $tickets = new TicketController();
    $router->get('/tickets/create', [$tickets,'form']);
    $router->post('/tickets/create', [$tickets,'create']);

    $open = new Web();
    $router->get('/', [$open, 'main']);
    $router->resolve();
?>