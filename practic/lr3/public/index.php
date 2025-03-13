<?php
    require __DIR__ ."/../vendor/autoload.php";

    use App\core\Router;
    use App\controller\UserController;

    $router = new Router();

    $users = new UserController();

    $router->get("/users", [$users, 'index']);

    $router->post('/users/add', [$users,'store']);

    $router->resolve();
?>