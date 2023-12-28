<?php
require_once 'config/Router.php';

/* This is the entry point of the application */

// Parse request url and method
$requestUrl = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Create a new router instance
$router = new \config\Router();
$router->handleRequest($requestUrl, $requestMethod);