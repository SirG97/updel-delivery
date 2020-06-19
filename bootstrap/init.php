<?php

// Start session
//use App\Controller\BaseController;
//use App\Controllers;

if(!isset($_SESSION)) session_start();

//Load environment variable
require_once __DIR__ . '/../App/Config/_env.php';

// Instantiate database class for the application
new App\Classes\Database();

//Set custom error handler
set_error_handler([new App\Classes\ErrorHandler(), 'handleErrors']);

//require the routes file
require_once __DIR__ . '/../app/routing/routes.php';


 new \App\RouteDispatcher($router);