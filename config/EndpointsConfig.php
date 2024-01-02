<?php

namespace config;

// Here we will add the endpoints
// All endpoints will be similar to the student and instrctor endpoints
// Based on what we need to do, we will add the corresponding endpoints
// We also need to add the corresponding controller class and methods
// Example:
// 'GET /neolearn-backend/index.php/courses' => 'CourseController@getAll',
class EndpointsConfig
{
    public static $studentRoutes = [
        // Get all students
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
        'POST /neolearn-backend/index.php/auth/student/login' => 'AuthenticationController@loginStudent'
    ];

    public static $instructorRoutes = [
        // Get all instructors
        'GET /neolearn-backend/index.php/instructors' => 'InstructorController@getAll',

        // Create a new instructor
        'POST /neolearn-backend/index.php/instructors' => 'InstructorController@createInstructor',

        // Get an instructor by id
        'GET /neolearn-backend/index.php/instructors/search/id/{instructorId}' => 'InstructorController@getById',

        // Get an instructor by email
        'GET /neolearn-backend/index.php/instructors/search/email/{instructorEmail}' => 'InstructorController@getByEmail',

        // Update an instructor
        'PUT /neolearn-backend/index.php/instructors' => 'InstructorController@update',

        // Delete an instructor
        'DELETE /neolearn-backend/index.php/instructors/delete/{instructorId}' => 'InstructorController@delete',

        // Authentication for instructors (login)
        'POST /neolearn-backend/index.php/auth/instructor/login' => 'AuthenticationController@loginInstructor'
    ];

    public static $courseRoutes = [

        // Get all courses
        'GET /neolearn-backend/index.php/courses' => 'CourseController@getAll',

        // Create a new course
        'POST /neolearn-backend/index.php/courses' => 'CourseController@createCourse',

        // Get a course by id
        'GET /neolearn-backend/index.php/courses/search/id/{courseId}' => 'CourseController@getById',

        // Get a course by name
        'GET /neolearn-backend/index.php/courses/search/name/{courseName}' => 'CourseController@getByName',

        // Update a course
        'PUT /neolearn-backend/index.php/courses' => 'CourseController@update',

        // Delete a course
        'DELETE /neolearn-backend/index.php/courses/delete/{courseId}' => 'CourseController@delete',

    ];

    // Not implemented yet
    public static $adminRoutes = [

    ];

    // Combine all the routes into one array
    // We will use this on index.php to get all the routes
    public static function getApiRoutes() {
        return array_merge(self::$studentRoutes, self::$instructorRoutes, self::$adminRoutes, self::$courseRoutes);
    }
}