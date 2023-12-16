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
$endpointMatched = false;

$conn = \config\DatabaseConfig::configDatabase();   // Connect to the database
$routes = \config\RoutesConfig::getApiRoutes();     // Get all the routes

// Match the route and call the corresponding controller method
foreach ($routes as $route => $controllerAction) {
    // Extract the route and method from the string
    list($routeMethod, $routePath) = explode(' ', $route);

    // Convert the route string to a regular expression
    $routePattern = str_replace('/', '\/', $routePath);

    // -------------------------------- Get Data from URL --------------------------------

    // If the url has a parameter like /students/search/id/1 we need to extract the id
    // We will use regular expressions to extract the id

    // Adjust the regular expression to capture the student ID - (Used for /students/search/id/{studentId})
    $routePattern = str_replace('{studentId}', '(\d+)', $routePattern);

    // Adjust the regular expression to capture the student email - (Used for /students/search/email/{studentEmail})
    $routePattern = str_replace('{studentEmail}', '([^/]+)', $routePattern);

    // Adjust the regular expression to capture the instructor ID - (Used for /instructors/search/id/{instructorId})
    $routePattern = str_replace('{instructorId}', '(\d+)', $routePattern);

    // Adjust the regular expression to capture the instructor email - (Used for /instructors/search/email/{instructorEmail})
    $routePattern = str_replace('{instructorEmail}', '([^/]+)', $routePattern);

    // If any more parameters are needed, add them here
    // ...

    // --------------------------------------------------------------------------------------

    // See if the current request matches the route
    if ($requestMethod === $routeMethod && preg_match("#^$routePattern$#", $requestUrl, $matches)) {

        // Extract the controller and action names
        list($controller, $action) = explode('@', $controllerAction);

        // Create an instance of the controller and call the action
        $controllerInstance = new $controller($conn); // Pass the database connection as a parameter

        // Remove the first element (full URL match)
        array_shift($matches);

        // Call the action method and pass any URL parameters to it
        call_user_func_array([$controllerInstance, $action], $matches);

        // Set the endpoint matched flag to true (Used for error handling)
        $endpointMatched = true;
        break;
    }
}

if (!$endpointMatched) {
    // If no route is matched, display an error
    header("HTTP/1.1 404 Not Found");
    header('Content-Type: application/json');

    // Create an error message
    $errorMsg = array();
    $errorMsg['error'] = "Endpoint not found";
    $errorMsg['message'] = "No endpoint found for the request method and url. Please check the documentation for the correct endpoints.";
    $errorMsg['method'] = $requestMethod;
    $errorMsg['url'] = $requestUrl;

    echo json_encode($errorMsg, JSON_PRETTY_PRINT);
}