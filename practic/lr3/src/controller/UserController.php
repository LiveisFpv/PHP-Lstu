<?php
namespace App\controller;

use App\Models\User;
use Twig\Enviroment;
use Twig\Loader\FilesystemLoader;

class UserController{
    private User $userModel;
    private Enviroment $twig;
    public function __construct(){
        $this->userModel = new User();
        $loader = new FilesystemLoader(__DIR__ ."/../views");
        $this->twig = new Enviroment($loader);
    }
    public function index():void{
        $users = $this->userModel->getAll();
        echo $this->twig->render('users.twig',['users'=>$users]);
    }

    public function store(): void{
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $this->userModel->addUser($_POST["name"], $_POST["email"], (int) $_POST["age"]);
        }
        header("Location: /users");
    }
}


?>