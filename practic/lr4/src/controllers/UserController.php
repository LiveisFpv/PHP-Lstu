<?php
// Объявляет пространство имён для контроллера пользователей
namespace App\controllers;

// Подключает модель User для работы с базой данных
use App\models\User;

// Подключает класс Twig Environment (шаблонизатор)
use Twig\Environment;

// Подключает загрузчик файловой системы Twig (для работы с шаблонами)
use Twig\Loader\FilesystemLoader;

// Определяет класс контроллера пользователей
class UserController {
    // Приватное свойство для работы с моделью пользователей (экземпляр User)
    private User $userModel;

    // Приватное свойство для работы с шаблонизатором Twig
    private Environment $twig;

    // Конструктор класса, вызывается при создании объекта UserController
    public function __construct() {
        // Создаёт объект модели User для взаимодействия с базой данных
        $this->userModel = new User();

        // Создаёт загрузчик шаблонов Twig, указывая путь к папке views
        $loader = new FilesystemLoader(__DIR__ . '/../views');

        // Создаёт объект Twig для рендеринга шаблонов
        $this->twig = new Environment($loader);
    }

    // Метод для обработки запроса GET /users
    public function index(): void {
        // Получает список всех пользователей из базы данных
        $users = $this->userModel->getAll();

        // Рендерит шаблон users.twig и передаёт в него массив с пользователями
        echo $this->twig->render('users.twig', ['users' => $users]);
    }

    // Метод для обработки запроса POST /users/add (добавление пользователя)
    public function store(): void {
        // Проверяет, что запрос был отправлен методом POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Вызывает метод addUser у модели User, передавая имя, email и возраст пользователя
            $this->userModel->addUser($_POST['name'], $_POST['email'], (int) $_POST['age']);
        }
        // Перенаправляет пользователя обратно на страницу /users после добавления
        header("Location: /users");
    }
}
?>
