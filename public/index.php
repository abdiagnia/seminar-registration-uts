<?php

declare(strict_types=1);

session_start();

$baseUrl = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

if ($baseUrl === '/') {
    $baseUrl = '';
}

define('BASE_URL', $baseUrl);

require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Participant.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ParticipantController.php';

$router = new Router();
$auth = new AuthController();
$participants = new ParticipantController();

$router->get(
    '/',
    fn () => !empty($_SESSION['user_id'])
        ? header('Location: ' . BASE_URL . '/participants')
        : header('Location: ' . BASE_URL . '/login')
);

$router->get('/login', fn () => $auth->login());
$router->post('/login', fn () => $auth->login());
$router->get('/logout', fn () => $auth->logout());

$router->get('/participants', fn () => $participants->index());
$router->get('/participants/create', fn () => $participants->create());
$router->post('/participants/store', fn () => $participants->store());
$router->get('/participants/edit/{id}', fn ($id) => $participants->edit($id));
$router->post('/participants/update', fn () => $participants->update());
$router->post('/participants/delete', fn () => $participants->destroy());

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
