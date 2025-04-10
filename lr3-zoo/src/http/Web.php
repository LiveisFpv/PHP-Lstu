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
    $router->get('/animals/create', [$animals, 'form'], [AuthMiddleware::class]);
    $router->post('/animals/create', [$animals, 'create'], [AuthMiddleware::class]);

    $cares = new CareController();
    $router->get('/cares', [$cares,'index'], [AuthMiddleware::class]);
    $router->get('/cares/create', [$cares,'form'], [AuthMiddleware::class]);
    $router->post('/cares/create', [$cares,'create'], [AuthMiddleware::class]);

    $users = new UserController();
    $router->get('/users', [$users,'index'], [AuthMiddleware::class]);
    $router->get('/users/auth', [$users,'auth_index']);
    $router->post('/users/auth', [$users,'auth']);
    $router->get('/users/logout', [$users, 'logout'], [AuthMiddleware::class]);
    $router->get('/users/create', [$users,'form']);
    $router->post('/users/create', [$users,'create']);

    $tickets = new TicketController();
    $router->get('/tickets/create', [$tickets,'form'], [AuthMiddleware::class]);
    $router->get('/tickets', [$tickets,'index'], [AuthMiddleware::class]);
    $router->post('/tickets/create', [$tickets,'create'], [AuthMiddleware::class]);

    $open = new Web();
    $router->get('/', [$open, 'main']);
    $router->resolve();
?>