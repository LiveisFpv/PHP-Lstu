<?php
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../src/http/Web.php';

    $loader = new \Twig\Loader\FilesystemLoader('./../src/views');
    $twig = new \Twig\Environment($loader, [
        'cache' => false,
    ]);

    return $twig;
?>