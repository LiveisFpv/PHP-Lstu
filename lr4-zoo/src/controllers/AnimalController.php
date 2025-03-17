<?php
class AnimalController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function index() {
        $animals = $this->model->getAllAnimals();
        include 'views/animal.php';
    }

    public function show($id) {
        $animal = $this->model->getAnimalById($id);
        include 'views/animal_detail.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'gender' => $_POST['gender'],
                'age' => $_POST['age'],
                'cage' => $_POST['cage'],
                'care' => $_POST['care']
            ];
            $this->model->addAnimal($data);
            header('Location: /');
        } else {
            include 'views/animal_create.php';
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'gender' => $_POST['gender'],
                'age' => $_POST['age'],
                'cage' => $_POST['cage'],
                'care' => $_POST['care']
            ];
            $this->model->updateAnimal($id, $data);
            header('Location: /');
        } else {
            $animal = $this->model->getAnimalById($id);
            include 'views/animal_edit.php';
        }
    }

    public function delete($id) {
        $this->model->deleteAnimal($id);
        header('Location: /');
    }
}
?>