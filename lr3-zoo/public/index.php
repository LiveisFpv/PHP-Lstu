<?php
    if (session_status() === PHP_SESSION_NONE ){
        session_start();
    }

    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../src/http/Web.php';

    $loader = new \Twig\Loader\FilesystemLoader('./../src/views');
    $twig = new \Twig\Environment($loader, [
        'cache' => false,
    ]);
    // $twig->addGlobal('user', $_SESSION["user"] ?? null);

    return $twig;
?>