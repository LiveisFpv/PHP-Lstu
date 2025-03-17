<?php
require_once 'config/Database.php';
require_once 'models/AnimalModel.php';
require_once 'controllers/AnimalController.php';
require_once 'core/Router.php';

$database = new Database();
$db = $database->getConnection();

$model = new AnimalModel($db);
$controller = new AnimalController($model);

$router = new Router();

$router->addRoute('/', 'AnimalController', 'index');
$router->addRoute('/show/{id}', 'AnimalController', 'show');
$router->addRoute('/create', 'AnimalController', 'create');
$router->addRoute('/edit/{id}', 'AnimalController', 'update');
$router->addRoute('/delete/{id}', 'AnimalController', 'delete');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($uri);
?>