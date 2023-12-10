<?php
require_once 'config/DatabaseConfig.php';
require __DIR__. '/controllers/StudentController.php';
require __DIR__. '/controllers/AuthenticationController.php';

require_once 'config/RoutesConfig.php';

/* This is the entry point of the application */

// Parse request url and method
$requestUrl = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Connect to the database
$conn = configDatabase();

// Include the routes from RoutesConfig.php
include 'config/RoutesConfig.php';

$routes = [
    // STUDENT ENDPOINTS
    // Get All Students
    'GET /neolearn-backend/index.php/students' => 'StudentController@getAll',

    // Create a new student
    'POST /neolearn-backend/index.php/students' => 'StudentController@createStudent',

    // Get a student by id
    'GET /neolearn-backend/index.php/students/search/id/{studentId}' => 'StudentController@getById',

    // Get a student by email
    'GET /neolearn-backend/index.php/students/search/email/{studentEmail}' => 'StudentController@getByEmail',

    // Update a student
    'PUT /neolearn-backend/index.php/students' => 'StudentController@update',

    // Delete a student
    'DELETE /neolearn-backend/index.php/students/delete/{studentId}' => 'StudentController@delete',

    // Get a student's courses
    'GET /neolearn-backend/index.php/students/search/{studentId}/courses' => 'StudentController@getCourses',

    // Add a course to a student
    'PUT /neolearn-backend/index.php/students/courses/add' => 'StudentController@addCourseToStudent', // Add a course to a user

    // AUTH
    'POST /neolearn-backend/index.php/auth/student/login' => 'AuthenticationController@loginStudent', // Login
];

// Match the route and call the corresponding controller method
// THIS SHOULD NEVER CHANGE (Not a good approach generally but for this project it's fine - kinda)
foreach ($routes as $route => $controllerAction) {
    // Extract the route and method from the string
    list($routeMethod, $routePath) = explode(' ', $route);

    // Convert the route string to a regular expression
    $routePattern = str_replace('/', '\/', $routePath);

    // STUDENT DETAILS SEARCH FOR ENDPOINTS
    // Adjust the regular expression to capture the student ID
    $routePattern = str_replace('{studentId}', '(\d+)', $routePattern);

    // Adjust the regular expression to capture the student email
    $routePattern = str_replace('{studentEmail}', '([^/]+)', $routePattern);

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
        break;
    }
}