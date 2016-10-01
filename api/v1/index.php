<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require ("../Classes/" . $classname . ".php");
});


$app = new \Slim\App;

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
});


$app->group('/participant', function () {
    $this->post('/create', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $registration = new Registration;
        $result['result'] = $registration->subscribe($data);

        header("Content-Type: application/json");
        echo json_encode($result);
    });
});

$app->run();
