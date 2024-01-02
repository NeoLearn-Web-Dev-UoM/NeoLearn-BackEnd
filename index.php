<?php
require_once 'config/RouterConfig.php';

/* This is the entry point of the application */

// Parse request url and method
$requestUrl = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Create a new router instance
$router = new \config\RouterConfig();
$router->handleRequest($requestUrl, $requestMethod);