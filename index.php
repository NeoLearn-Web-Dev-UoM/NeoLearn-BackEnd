<?php
require_once 'config/DatabaseConfig.php';
require __DIR__. '/controllers/StudentController.php';
require __DIR__. '/controllers/AuthenticationController.php';

/* This is the entry point of the application */

// Parse request url and method
$requestUrl = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Connect to the database
$conn = configDatabase();

$routes = [
    // -------------------------------- STUDENT ENDPOINTS --------------------------------
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
    'PUT /neolearn-backend/index.php/students/courses/add' => 'StudentController@addCourseToStudent',

    // Remove a course from a student
    'PUT /neolearn-backend/index.php/students/courses/remove' => 'StudentController@removeCourseFromStudent',

    // Authentication for student (login)
    'POST /neolearn-backend/index.php/auth/student/login' => 'AuthenticationController@loginStudent',

    // -------------------------------- INSTRUCTOR ENDPOINTS --------------------------------

    // Get All Instructors
    'GET /neolearn-backend/index.php/instructors' => 'InstructorController@getAll',

    // Create a new instructors
    'POST /neolearn-backend/index.php/instructors' => 'InstructorController@createInstructor',

    // Get a instructors by id
    'GET /neolearn-backend/index.php/instructors/search/id/{studentId}' => 'InstructorController@getById',

    // Get a instructors by email
    'GET /neolearn-backend/index.php/instructors/search/email/{studentEmail}' => 'InstructorController@getByEmail',

    // Update a instructors
    'PUT /neolearn-backend/index.php/instructors' => 'InstructorController@update',

    // Delete a instructors
    'DELETE /neolearn-backend/index.php/instructors/delete/{studentId}' => 'InstructorController@delete',

    // Get a instructors's courses
    'GET /neolearn-backend/index.php/instructors/search/{studentId}/courses' => 'InstructorController@getCourses',

    // Add a course to a instructors
    'PUT /neolearn-backend/index.php/instructors/courses/add' => 'InstructorController@addCourseToInstructor',

    // Remove a course from a instructors
    'PUT /neolearn-backend/index.php/instructors/courses/remove' => 'InstructorController@removeCourseFromInstructor',

    // Authentication for instructors (login)
    'POST /neolearn-backend/index.php/auth/instructor/login' => 'AuthenticationController@loginInstructor',

    // -------------------------------- COURSE ENDPOINTS ------------------------------------

    // Here we will add the course endpoints
    // The course endpoints will be similar to the student endpoints
    // Based on what we need to do, we will add the corresponding endpoints
    // We also need to add the corresponding controller class and methods
    // Example:
    // 'GET /neolearn-backend/index.php/courses' => 'CourseController@getAll',
];

// Match the route and call the corresponding controller method
// THIS SHOULD NEVER CHANGE (expect for getting the endpoint parameters)
foreach ($routes as $route => $controllerAction) {
    // Extract the route and method from the string
    list($routeMethod, $routePath) = explode(' ', $route);

    // Convert the route string to a regular expression
    $routePattern = str_replace('/', '\/', $routePath);

    // -------------------------------- Get Data from URL --------------------------------

    // If the url has a parameter like /students/search/id/1 we need to extract the id
    // We will use regular expressions to extract the id
    // Example:

    // Adjust the regular expression to capture the student ID - (Used for /students/search/id/{studentId})
    $routePattern = str_replace('{studentId}', '(\d+)', $routePattern);

    // Adjust the regular expression to capture the student email - (Used for /students/search/email/{studentEmail})
    $routePattern = str_replace('{studentEmail}', '([^/]+)', $routePattern);

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
        break;
    }
}