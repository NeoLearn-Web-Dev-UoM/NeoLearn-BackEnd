<?php

require_once 'models/Instructor.php';
require_once 'db/InstructorDatabase.php';

class InstructorController
{
    private $instructorDatabase;

    public function __construct($conn)
    {
        $this->instructorDatabase = new InstructorDatabase($conn);
    }

    // GET (by all)
    // GET - /instructors/
    public function getAll()
    {
        try {
            // Try to get all the instructors from the database
            $instructors = $this->instructorDatabase->getAll();

            // If everything went well return the students as JSON
            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($instructors);

        } catch (Exception $e) {
            // If something went wrong return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to get instructors',
                'error' => $e->getMessage()
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }
    }


    // GET INSTRUCTOR BY ID (SELECT 2)
    public function getById($id)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the instructor ID from the URL and can access it as a parameter ($id)
        header('Content-Type: application/json');
        $instructor = $this->instructorDatabase->getById($id);

        // Check if the student exists
        if ($instructor === null) {
            // If the student doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(404);

            $message = array(
                'message' => 'Failed to get instructor',
                'error' => 'Instructor not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the instructor as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($instructor);
    }

    //GET INSTRUCTOR BY EMAIL 
    public function getByEmail($email)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the student ID from the URL and can access it as a parameter ($id)
        header('Content-Type: application/json');

        // Make the

        $instructor = $this->instructorDatabase->getByEmail($email);

        // Check if the student exists
        if ($instructor === null) {
            // If the student doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(404);

            $message = array(
                'message' => 'Failed to get instructor',
                'error' => 'Instructor not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the instructor as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($instructor);
    }


    // CREATE INSTRUCTOR (INSERT)
    // POST - /neolearn-backend/index.php/instructors ????
    public function createInstructor()
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
        $existingInstructor = $this->instructorDatabase->getByEmail($requestEmail);

        if ($existingInstructor !== null) {
            // If the email already exists return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to create instructor',
                'error' => 'Email already exists'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Now create and save the new instructor
        $hashedPassword = password_hash($requestPassword, PASSWORD_DEFAULT);    // First hash the password
        $instructor = new Instructor($requestEmail, $hashedPassword);                      // Create the instructor object

        $saved = $this->instructorDatabase->save($instructor);

        // Check if the instructor was saved successfully
        if ($saved === null) {
            // If the instructor wasn't saved successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to create instructor',
                'error' => 'Instructor not saved'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the instructor as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($saved);
    }


    // UPDATE INSTRUCTOR (UPDATE)
    // PUT - /neolearn-backend/index.php/instructors
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
                'message' => 'Failed to update instructor',
                'error' => 'Request body is empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the instructor ID, email and password from the request body
        $requestInstructorId = $jsonRequestBody->id;
        $requestEmail = $jsonRequestBody->email;
        $requestPassword = $jsonRequestBody->password;

        // Check that the instructor id exists
        $existingInstructor = $this->instructorDatabase->getById($requestInstructorId);

        if ($existingInstructor === null) {
            // If the instructor doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to update instructor',
                'error' => 'Instructor not found'
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
                'message' => 'Failed to update instructor',
                'error' => 'Email or password are empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Now update the instructor
        // First hash the password
        $hashedPassword = password_hash($requestPassword, PASSWORD_DEFAULT);

        $updatedInstructor = new Instructor($requestEmail, $hashedPassword);
        $updatedInstructor->setId($requestInstructorId);

        $updated = $this->instructorDatabase->update($updatedInstructor);

        // Check if the instructor was updated successfully
        if ($updated === null) {
            // If the instructor wasn't updated successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to update instructor',
                'error' => 'Instructor not updated'
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


    // DELETE INSTRUCTOR (DELETE)
    // DELETE - /neolearn-backend/index.php/instructors/delete/XXX ????
    public function delete($instructorId)
    {
        // Check if the instructor exists
        $existingInstructor = $this->instructorDatabase->getById($instructorId);

        if ($existingInstructor === null) {
            // If the instructor doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to delete instructor',
                'error' => 'Instructor not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the instructor exists.
        $deleted = $this->instructorDatabase->delete($instructorId);

        // Check if the instructor was deleted successfully
        if ($deleted === false) {
            // If the instructor wasn't deleted successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to delete instructor',
                'error' => 'Instructor not deleted'
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
            'message' => 'Instructor deleted successfully'
        );

        // Return the success message as JSON
        echo json_encode($message);
    }

    // GET ALL COURSES FOR INSTRUCTOR
    // GET - /neolearn-backend/index.php/instructors/search/XXX/courses ???
    public function getCourses($instructorId)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the instructor ID from the URL and can access it as a parameter ($id)

        // Check if the student exists
        $existingInstructor = $this->instructorDatabase->getById($instructorId);

        if ($existingInstructor === null) {
            // If the instructor doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to get courses',
                'error' => 'Instructor not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the instructor exists.
        $courses = $this->instructorDatabase->getAllCoursesForInstructor($instructorId);

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

    // ADD COURSE TO INSTRUCTOR
    // POST - /neolearn-backend/index.php/instructor/courses/add ???
    public function addCourseToInstructor()
    {
        // Get the request body
        $requestBody = file_get_contents('php://input');

        // Make sure that the request body is not empty
        if (empty($requestBody)) {
            // If the request body is empty return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed add course to instructor',
                'error' => 'Request body is empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the instructor ID and course ID from the request body
        $requestInstructorId = $jsonRequestBody->InstructorId;
        $requestCourseId = $jsonRequestBody->courseId;

        // Check that the instructor and course exist
        $existingInstructor = $this->instructorDatabase->getById($requestInstructorId);
        $existingCourse = $this->courseDatabase->getById($requestCourseId);

        if ($existingInstructor === null || $existingCourse === null) {
            $instructorFound = $existingInstructor !== null;
            $courseFound = $existingCourse !== null;

            // If the instructor or course doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed add course to instructor',
                'error' => 'Instructor or course not found',
                'instructorFound' => $instructorFound,
                'courseFound' => $courseFound
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the instructor and course exist.
        $added = $this->instructorDatabase->addCourseToInstructor($requestInstructorId, $requestCourseId);

        // Check if the course was added successfully
        if ($added === false) {
            // If the course wasn't added successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed add course to instructor',
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

    // REMOVE COURSE FROM INSTRUCTOR
    // DELETE - /neolearn-backend/index.php/instructors/courses/remove ????
    public function removeCourseFromInstructors() {
        // Get the request body
        $requestBody = file_get_contents('php://input');

        // Make sure that the request body is not empty
        if (empty($requestBody)) {
            // If the request body is empty return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed remove course from instructor',
                'error' => 'Request body is empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the instructor ID and course ID from the request body
        $requestInstructorId = $jsonRequestBody->InstructorId;
        $requestCourseId = $jsonRequestBody->courseId;

        // Check that the instructor and course exist
        $existingInstructor = $this->instructorDatabase->getById($requestInstructorId);
        $existingCourse = $this->courseDatabase->getById($requestCourseId);

        if ($existingInstructor === null || $existingCourse === null) {
            $instructorFound = $existingInstructor !== null;
            $courseFound = $existingCourse !== null;

            // If the instructor or course doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed remove course from instructor',
                'error' => 'Instructor or course not found',
                'instructorFound' => $instructorFound,
                'courseFound' => $courseFound
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the student and course exist.
        $removed = $this->instructorDatabase->removeCourseFromInstructor($requestInstructorId, $requestCourseId);

        // Check if the course was removed successfully
        if ($removed === false) {
            // If the course wasn't removed successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed remove course from instructor',
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
