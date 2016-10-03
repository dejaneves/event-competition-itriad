<?php
use Slim\Views\PhpRenderer;

include "../vendor/autoload.php";
spl_autoload_register(function ($classname) {
    require ("../api/Classes/" . $classname . ".php");
});

$app = new Slim\App();
$container = $app->getContainer();
$container['renderer'] = new PhpRenderer("./templates");

$app->get('/destroy', function ($request, $response, $args) {
    $args = ["page" => "destroy"];
    return $this->renderer->render($response, "/common.php", $args);
});

$app->get('/hello/{name}', function ($request, $response, $args) {
    $args = ["page" => "hello"];
    return $this->renderer->render($response, "/common.php", $args);
});

// Home
$app->get('/home', function ($request, $response, $args) {
    $args = ["page" => "home"];
    return $this->renderer->render($response, "/common.php", $args);
});

// Login
$app->get('/login', function ($request, $response, $args) {
    $args = ["page" => "login"];
    return $this->renderer->render($response, "/common.php",$args);
});

$app->run();
