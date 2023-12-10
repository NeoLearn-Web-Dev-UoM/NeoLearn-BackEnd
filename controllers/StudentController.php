<?php

require_once 'db/StudentDatabase.php';
require_once 'db/CourseDatabase.php';
require_once 'models/Student.php';


class StudentController
{
    private $studentDatabase;
    private $courseDatabase;

    public function __construct($dbConnection)
    {
        $this->studentDatabase = new StudentDatabase($dbConnection);
        $this->courseDatabase = new CourseDatabase($dbConnection);
    }

    // GET ALL STUDENTS (SELECT 1)
    // GET - /neolearn-backend/index.php/students
    public function getAll()
    {
        // Try to get all the students from the database
        try {
            $students = $this->studentDatabase->getAll();

            // If everything went well return the students as JSON
            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($students);

        } catch (Exception $e) {
            // If something went wrong return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to get students',
                'error' => $e->getMessage()
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }
    }

    // GET STUDENT BY ID (SELECT 2)
    // GET - /neolearn-backend/index.php/students/XXX
    public function getById($id)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the student ID from the URL and can access it as a parameter ($id)
        header('Content-Type: application/json');
        $student = $this->studentDatabase->getById($id);

        // Check if the student exists
        if ($student === null) {
            // If the student doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(404);

            $message = array(
                'message' => 'Failed to get student',
                'error' => 'Student not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the student as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($student);
    }

    // GET STUDENT BY EMAIL (SELECT 3)
    // GET - /neolearn-backend/index.php/students/search/email/XXX
    public function getByEmail($email)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the student ID from the URL and can access it as a parameter ($id)
        header('Content-Type: application/json');

        // Make the

        $student = $this->studentDatabase->getByEmail($email);

        // Check if the student exists
        if ($student === null) {
            // If the student doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(404);

            $message = array(
                'message' => 'Failed to get student',
                'error' => 'Student not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the student as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($student);
    }

    // CREATE STUDENT (INSERT)
    // POST - /neolearn-backend/index.php/students
    public function createStudent()
    {
        // Get the request body
        $requestBody = file_get_contents('php://input');

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the email and password from the request body
        $requestEmail = $jsonRequestBody->email;
        $requestPassword = $jsonRequestBody->password;

        // Make sure that the email and password are not empty
        if (empty($requestEmail) || empty($requestPassword)) {
            // If the email or password are empty return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to create student',
                'error' => 'Email or password are empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Make sure that the email doesn't already exist
        $existingStudent = $this->studentDatabase->getByEmail($requestEmail);

        if ($existingStudent !== null) {
            // If the email already exists return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to create student',
                'error' => 'Email already exists'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Now create and save the new student
        $hashedPassword = password_hash($requestPassword, PASSWORD_DEFAULT);    // First hash the password
        $student = new Student($requestEmail, $hashedPassword);                      // Create the student object

        $saved = $this->studentDatabase->save($student);

        // Check if the student was saved successfully
        if ($saved === null) {
            // If the student wasn't saved successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to create student',
                'error' => 'Student not saved'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the student as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($saved);
    }

    // UPDATE STUDENT (UPDATE)
    // PUT - /neolearn-backend/index.php/students
    public function update()
    {
        // Get the request body
        $requestBody = file_get_contents('php://input');

        // Make sure that the request body is not empty
        if (empty($requestBody)) {
            // If the request body is empty return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to update student',
                'error' => 'Request body is empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the student ID, email and password from the request body
        $requestStudentId = $jsonRequestBody->id;
        $requestEmail = $jsonRequestBody->email;
        $requestPassword = $jsonRequestBody->password;

        // Check that the user id exists
        $existingStudent = $this->studentDatabase->getById($requestStudentId);

        if ($existingStudent === null) {
            // If the student doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to update student',
                'error' => 'Student not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Make sure that the email and password are not empty
        if (empty($requestEmail) || empty($requestPassword)) {
            // If the email or password are empty return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to update student',
                'error' => 'Email or password are empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Now update the student
        // First hash the password
        $hashedPassword = password_hash($requestPassword, PASSWORD_DEFAULT);

        $updatedStudent = new Student($requestEmail, $hashedPassword);
        $updatedStudent->setId($requestStudentId);

        $updated = $this->studentDatabase->update($updatedStudent);

        // Check if the student was updated successfully
        if ($updated === null) {
            // If the student wasn't updated successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to update student',
                'error' => 'Student not updated'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the student as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($updated);
    }

    // DELETE STUDENT (DELETE)
    // DELETE - /neolearn-backend/index.php/students/delete/XXX
    public function delete($studentId)
    {
        // Check if the student exists
        $existingStudent = $this->studentDatabase->getById($studentId);

        if ($existingStudent === null) {
            // If the student doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to delete student',
                'error' => 'Student not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the student exists.
        $deleted = $this->studentDatabase->delete($studentId);

        // Check if the student was deleted successfully
        if ($deleted === false) {
            // If the student wasn't deleted successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to delete student',
                'error' => 'Student not deleted'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return a success message
        header('Content-Type: application/json');
        http_response_code(200);

        $message = array(
            'message' => 'Student deleted successfully'
        );

        // Return the success message as JSON
        echo json_encode($message);
    }

    // GET ALL COURSES FOR STUDENT
    // GET - /neolearn-backend/index.php/students/search/XXX/courses
    public function getCourses($studentId)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the student ID from the URL and can access it as a parameter ($id)

        // Check if the student exists
        $existingStudent = $this->studentDatabase->getById($studentId);

        if ($existingStudent === null) {
            // If the student doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to get courses',
                'error' => 'Student not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the student exists.
        $courses = $this->studentDatabase->getAllCoursesForStudent($studentId);

        // Check if the courses were retrieved successfully
        if ($courses === null) {
            // If the courses weren't retrieved successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to get courses',
                'error' => 'Courses not retrieved'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the courses as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($courses);
    }

    // ADD COURSE TO STUDENT
    // POST - /neolearn-backend/index.php/students/courses/add
    public function addCourseToStudent()
    {
        // Get the request body
        $requestBody = file_get_contents('php://input');

        // Make sure that the request body is not empty
        if (empty($requestBody)) {
            // If the request body is empty return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed add course to student',
                'error' => 'Request body is empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the student ID and course ID from the request body
        $requestStudentId = $jsonRequestBody->studentId;
        $requestCourseId = $jsonRequestBody->courseId;

        // Check that the student and course exist
        $existingStudent = $this->studentDatabase->getById($requestStudentId);
        $existingCourse = $this->courseDatabase->getById($requestCourseId);

        if ($existingStudent === null || $existingCourse === null) {
            $studentFound = $existingStudent !== null;
            $courseFound = $existingCourse !== null;

            // If the student or course doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed add course to student',
                'error' => 'Student or course not found',
                'studentFound' => $studentFound,
                'courseFound' => $courseFound
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the student and course exist.
        $added = $this->studentDatabase->addCourseToStudent($requestStudentId, $requestCourseId);

        // Check if the course was added successfully
        if ($added === false) {
            // If the course wasn't added successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed add course to student',
                'error' => 'Course not added'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return a success message
        header('Content-Type: application/json');
        http_response_code(200);

        $message = array(
            'message' => 'Course added successfully'
        );

        // Return the success message as JSON
        echo json_encode($message);
    }

    // REMOVE COURSE FROM STUDENT
    // DELETE - /neolearn-backend/index.php/students/courses/remove
    public function removeCourseFromStudent() {
        // Get the request body
        $requestBody = file_get_contents('php://input');

        // Make sure that the request body is not empty
        if (empty($requestBody)) {
            // If the request body is empty return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed remove course from student',
                'error' => 'Request body is empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the student ID and course ID from the request body
        $requestStudentId = $jsonRequestBody->studentId;
        $requestCourseId = $jsonRequestBody->courseId;

        // Check that the student and course exist
        $existingStudent = $this->studentDatabase->getById($requestStudentId);
        $existingCourse = $this->courseDatabase->getById($requestCourseId);

        if ($existingStudent === null || $existingCourse === null) {
            $studentFound = $existingStudent !== null;
            $courseFound = $existingCourse !== null;

            // If the student or course doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed remove course from student',
                'error' => 'Student or course not found',
                'studentFound' => $studentFound,
                'courseFound' => $courseFound
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the student and course exist.
        $removed = $this->studentDatabase->removeCourseFromStudent($requestStudentId, $requestCourseId);

        // Check if the course was removed successfully
        if ($removed === false) {
            // If the course wasn't removed successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed remove course from student',
                'error' => 'Course not removed'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return a success message
        header('Content-Type: application/json');
        http_response_code(200);

        $message = array(
            'message' => 'Course removed successfully from user list'
        );

        // Return the success message as JSON
        echo json_encode($message);
    }
}