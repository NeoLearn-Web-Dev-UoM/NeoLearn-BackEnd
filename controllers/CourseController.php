<?php
require_once 'db/CourseDatabase.php';
require_once 'models/Course.php';

class CourseController
{
    private $courseDatabase;

    public function __construct($conn)
    {
        $this->courseDatabase = new CourseDatabase($conn);
    }

    // Get all courses
    // GET /neolearn-backend/index.php/courses
    public function getAll()
    {
        // Try to get all the courses from the database
        try {
            $courses = $this->courseDatabase->getAll();

            // If everything went well return the courses as JSON
            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($courses);

        } catch (Exception $e) {
            // If something went wrong return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to get courses',
                'error' => $e->getMessage()
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }
    }

    // Get a course by id
    // GET /neolearn-backend/index.php/courses/search/id/{courseId}
    public function getById($id)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the course ID from the URL and can access it as a parameter ($id)
        header('Content-Type: application/json');
        $course = $this->courseDatabase->getById($id);

        // Check if the course exists
        if ($course === null) {
            // If the course doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(404);

            $message = array(
                'message' => 'Failed to get course',
                'error' => 'Course not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the course as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($course);
    }

    // Get courses by instructor id
    // GET /neolearn-backend/index.php/courses/search/instructor/{instructorId}
    public function getByInstructorId($instructorId)
    {
        // TODO: Implement getByInstructorId() method.
    }

    // Create a new course
    // POST /neolearn-backend/index.php/courses
    public function createCourse()
    {
        // Get the request body
        $requestBody = file_get_contents('php://input');

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the name, videoUrl and instructorId from the request body
        $requestName = $jsonRequestBody->name;
        $requestVideoUrl = $jsonRequestBody->videoUrl;
        $requestInstructorId = $jsonRequestBody->instructorId;

        // Make sure that the name, videoUrl and instructorId are not empty
        if (empty($requestName) || empty($requestVideoUrl) || empty($requestInstructorId)) {
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to create course',
                'error' => 'Name, VideoUrl or InstructorId are empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Make sure that the name doesn't already exist
        $existingCourse = $this->courseDatabase->getByName($requestName);

        if ($existingCourse !== null) {
            // If the name already exists return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to create course',
                'error' => 'CourseName already exists'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Now create and save the new course
        $course = new Course($requestName, $requestVideoUrl, $requestInstructorId);

        $saved = $this->courseDatabase->save($course);

        // Check if the course was saved successfully
        if ($saved === null) {
            // If the course wasn't saved successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to create course',
                'error' => 'Course not saved'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the course as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($saved);
    }

    // Update a course
    // PUT /neolearn-backend/index.php/courses
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
                'message' => 'Failed to update course',
                'error' => 'Request body is empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Parse the request body as JSON
        $jsonRequestBody = json_decode($requestBody);

        // Get the id, name, videoUrl and instructorId from the request body
        $requestCourseId = $jsonRequestBody->id;
        $requestName = $jsonRequestBody->name;
        $requestVideoUrl = $jsonRequestBody->videoUrl;
        $requestInstructorId = $jsonRequestBody->instructorId;

        // Check that the name exists
        $existingCourse = $this->courseDatabase->getByName($requestName);

        if ($existingCourse === null) {
            // If the course doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to update course',
                'error' => 'Course not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Make sure that the name, videoUrl and instructorId are not empty
        if (empty($requestName) || empty($requestVideoUrl) || empty($requestInstructorId)) {
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to create course',
                'error' => 'Name, VideoUrl or InstructorId are empty'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // Now update the course

        $updatedCourse = new Course($requestName, $requestVideoUrl, $requestInstructorId);

        $updatedCourse->setId($requestCourseId);

        $updated = $this->courseDatabase->update($updatedCourse);

        // Check if the course was updated successfully
        if ($updated === null) {
            // If the course wasn't updated successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to update course',
                'error' => 'Course not updated'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // If everything went well return the course as JSON
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($updated);
    }

    // Delete a course
    // DELETE /neolearn-backend/index.php/courses/delete/{courseId}
    public function delete($courseId)
    {
        // Check if the course exists
        $existingCourse = $this->courseDatabase->getById($courseId);

        if ($existingCourse === null) {
            // If the course doesn't exist return an error message
            header('Content-Type: application/json');
            http_response_code(400);

            $message = array(
                'message' => 'Failed to delete course',
                'error' => 'Course not found'
            );

            // Return the error message as JSON
            echo json_encode($message);

            // Stop the execution of the script.
            return null;
        }

        // We will get to this point only if the course exists.
        $deleted = $this->courseDatabase->delete($courseId);

        // Check if the course was deleted successfully
        if ($deleted === false) {
            // If the course wasn't deleted successfully return an error message
            header('Content-Type: application/json');
            http_response_code(500);

            $message = array(
                'message' => 'Failed to delete course',
                'error' => 'Course not deleted'
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
            'message' => 'Course deleted successfully'
        );

        // Return the success message as JSON
        echo json_encode($message);
    }
}