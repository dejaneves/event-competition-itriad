<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
spl_autoload_register(function ($classname) {
    require ("../Classes/" . $classname . ".php");
});

$app = new \Slim\App;

$app->group('/participant', function () {
    $this->post('/create', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $registration = new Registration;
        $result['result'] = $registration->subscribe($data);
        header("Content-Type: application/json");
        echo json_encode($result);
    });
    $this->post('/modality', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $registration = new Registration;
        $registration->subscribeModality($data);
        header("Content-Type: application/json");
        echo json_encode($registration->rowCountSubscribeModality);
    });
});

// Login
$app->post('/register', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $login = new Login;
    $login->register($data);
    header("Content-Type: application/json");
    echo json_encode($login->result);
});

// Competition Active
$app->get('/competition/active', function ($request, $response, $args) {
    $competition = new Competition;
    $competition->fetchCompetitionActive();
    header("Content-Type: application/json");
    echo json_encode($competition->result);
});
// Competition by id
$app->get('/competition/id/{id}', function ($request, $response, $args) {
    $competition = new Competition;
    $competition->fetchId($args['id']);
    header("Content-Type: application/json");
    echo json_encode($competition->result);
});

$app->get('/modality/all', function ($request, $response, $args) {
    $modality = new Modality;
    $modality->modalityCompetition();
    header("Content-Type: application/json");
    echo json_encode($modality->result);
});


// Check Session Server
$app->get('/session', function () {
    $data = Session::getInstance();
    $user['name'] = $data->name;
    $user['email'] = $data->email;
    $user['id'] = $data->id;
    header("Content-Type: application/json");
    echo json_encode($user);
});

$app->run();
