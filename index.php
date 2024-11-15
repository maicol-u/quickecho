<?php
require 'vendor/autoload.php';
require 'Middlewares/SessionMiddleware.php';

use Core\Router;
use Core\View;

$app = new Router();

$app->get('/', function () {
    View::render('Views/Home.php');
});

$app->get('/users', 'UserController@getUsers', [logMiddleware()]);

$app->run();
