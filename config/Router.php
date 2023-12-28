<?php
namespace config;

require 'controllers/StudentController.php';
require 'controllers/InstructorController.php';
require 'controllers/CourseController.php';
require 'controllers/AuthenticationController.php';

require 'config/RoutesConfig.php';
require_once 'config/DatabaseConfig.php';


class Router
{
    private $conn;
    private $routes;

    public function __construct()
    {
        $this->conn = DatabaseConfig::configDatabase();
        $this->routes = RoutesConfig::getApiRoutes();
    }

    // This method will be used to handle the request
    public function handleRequest($requestUrl, $requestMethod)
    {
        $endpointMatched = false;

        // Match the route and call the corresponding controller method
        foreach ($this->routes as $route => $controllerAction) {
            // Extract the route and method from the string
            list($routeMethod, $routePath) = explode(' ', $route);

            // Convert the route string to a regular expression
            $routePattern = str_replace('/', '\/', $routePath);

            $routePattern = $this->extractParameters($routePattern);

            // See if the current request matches the route
            $requestMethodMatches = $requestMethod === $routeMethod;
            $patternMatches = preg_match("#^$routePattern$#", $requestUrl, $matches);

            if ($requestMethodMatches && $patternMatches) {
                $this->handleMatchedRoute($controllerAction, $matches);

                $endpointMatched = true;
                break;
            }
        }

        // If no route is matched, return an error
        if (!$endpointMatched) $this->handleUnmatchedRoute($requestMethod, $requestUrl);
    }

    // This method will be used to handle a matched route
    public function handleMatchedRoute($controllerAction, $matches) {
        // Extract the controller and action names
        list($controller, $action) = explode('@', $controllerAction);

        // Create an instance of the controller and call the action
        $controllerInstance = new $controller($this->conn); // Pass the database connection as a parameter

        // Remove the first element (full URL match)
        array_shift($matches);

        // Call the action method and pass any URL parameters to it
        call_user_func_array([$controllerInstance, $action], $matches);
    }

    // This method will be used if no route is matched
    public  function handleUnmatchedRoute($requestMethod, $requestUrl) {
        header("HTTP/1.1 404 Not Found");
        header('Content-Type: application/json');

        // Create an error message
        $errorMsg = array();
        $errorMsg['error'] = "Endpoint not found";
        $errorMsg['message'] = "No endpoint found for the request method and url. Please check the documentation for the correct endpoints.";
        $errorMsg['method'] = $requestMethod;
        $errorMsg['url'] = $requestUrl;

        return $errorMsg;
    }

    // This method extracts possible parameters from the URL
    public function extractParameters($routePattern) {
        // Adjust the regular expression to capture the student ID - (Used for /students/search/id/{studentId})
        $routePattern = str_replace('{studentId}', '(\d+)', $routePattern);

        // Adjust the regular expression to capture the student email - (Used for /students/search/email/{studentEmail})
        $routePattern = str_replace('{studentEmail}', '([^/]+)', $routePattern);

        // Adjust the regular expression to capture the instructor ID - (Used for /instructors/search/id/{instructorId})
        $routePattern = str_replace('{instructorId}', '(\d+)', $routePattern);

        // Adjust the regular expression to capture the instructor email - (Used for /instructors/search/email/{instructorEmail})
        $routePattern = str_replace('{instructorEmail}', '([^/]+)', $routePattern);

        // If any more parameters are needed, add them here

        return $routePattern;
    }
}