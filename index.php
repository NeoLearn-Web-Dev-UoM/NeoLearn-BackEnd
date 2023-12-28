<?php
require_once 'config/DatabaseConfig.php';
require_once 'config/RoutesConfig.php';
require __DIR__. '/controllers/StudentController.php';
require __DIR__. '/controllers/AuthenticationController.php';
require __DIR__. '/controllers/InstructorController.php';

/* This is the entry point of the application */

// Parse request url and method
$requestUrl = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Connect to the database
$conn = \config\DatabaseConfig::configDatabase();

// Create a new router instance
$router = new \config\Router($conn);
$router->handleRequest($requestUrl, $requestMethod);