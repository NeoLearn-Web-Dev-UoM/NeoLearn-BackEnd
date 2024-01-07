<?php
require_once 'db/CourseDatabase.php';
require_once 'models/Course.php';

class CourseController
{
    private $courseDatabase;
    private $instructorDatabase;

    public function __construct($conn)
    {
        $this->courseDatabase = new CourseDatabase($conn);
        $this->instructorDatabase = new InstructorDatabase($conn);
    }

    // Get all courses - OK
    // GET /neolearn-backend/index.php/courses
    public function getAll()
    {
        // Try to get all the courses from the database
        try {
            $courses = $this->courseDatabase->getAll();

            \controllers\ControllerUtils::sendSuccessResponse(200, $courses);

        } catch (Exception $e) {
            $message = array(
                'message' => 'Failed to get courses',
                'error' => $e->getMessage()
            );

            \controllers\ControllerUtils::sendErrorResponse(500, $message);
        }
    }

    // Get a course by id - OK
    // GET /neolearn-backend/index.php/courses/search/id/{courseId}
    public function getById($id)
    {
        // We implemented the routing logic in the index.php file
        // We automatically get the course ID from the URL and can access it as a parameter ($id)
        try {
            $course = $this->courseDatabase->getById($id);

            // Check if the course exists
            if ($course === null) {
                $message = array(
                    'message' => 'Failed to get course',
                    'error' => 'Course not found'
                );

                \controllers\ControllerUtils::sendErrorResponse(404, $message);
            }

            \controllers\ControllerUtils::sendSuccessResponse(200, $course);
        } catch (Exception $e) {
            $message = array(
                'message' => 'Failed to get course',
                'error' => $e->getMessage()
            );

            \controllers\ControllerUtils::sendErrorResponse(500, $message);
        }
    }

    // Get courses by name
    // GET /neolearn-backend/index.php/courses/search/name/
    public function getByName()
    {
        try {
            // Get the request body
            $requestBody = file_get_contents('php://input');

            // Parse the request body as JSON
            $jsonRequestBody = json_decode($requestBody);

            // Get the name from the request body
            $name = $jsonRequestBody->name;

            $courses = $this->courseDatabase->getByName($name);

            \controllers\ControllerUtils::sendSuccessResponse(200, $courses);
        } catch (Exception $e) {
            $message = array(
                'message' => 'Failed to get course',
                'error' => $e->getMessage()
            );

            \controllers\ControllerUtils::sendErrorResponse(500, $message);
        }
    }

    // Get courses by instructor id - NOT IMPLEMENTED
    // GET /neolearn-backend/index.php/courses/search/instructor/{instructorId}
    public function getByInstructorId($instructorId)
    {
        try {
            $courses = $this->courseDatabase->getByInstructorId($instructorId);

            \controllers\ControllerUtils::sendSuccessResponse(200, $courses);
        } catch (Exception $e) {
            $message = array(
                'message' => 'Failed to get course',
                'error' => $e->getMessage()
            );

            \controllers\ControllerUtils::sendErrorResponse(500, $message);
        }
    }

    // Create a new course - OK
    // POST /neolearn-backend/index.php/courses
    public function createCourse()
    {
        try {
            // Get the request body
            $requestBody = file_get_contents('php://input');

            // Parse the request body as JSON
            $jsonRequestBody = json_decode($requestBody);

            // Get the name, videoUrl and instructorId from the request body
            $requestName = $jsonRequestBody->name;
            $requestVideoUrl = $jsonRequestBody->videoUrl;
            $requestInstructorId = $jsonRequestBody->instructorId;
            $requestDesc = $jsonRequestBody->description;

            // Make sure that the name, videoUrl and instructorId are not empty
            if (empty($requestName) || empty($requestVideoUrl) || empty($requestInstructorId)) {
                $message = array(
                    'message' => 'Failed to create course',
                    'error' => 'Name, VideoUrl or InstructorId are empty'
                );

                \controllers\ControllerUtils::sendErrorResponse(400, $message);
            }

            // Check if the instructor exists
            $existingInstructor = $this->instructorDatabase->getById($requestInstructorId);

            if ($existingInstructor === null) {
                $message = array(
                    'message' => 'Failed to create course',
                    'error' => 'Instructor not found'
                );

                \controllers\ControllerUtils::sendErrorResponse(404, $message);
            }

            // Now create and save the new course
            $course = new Course($requestName, $requestVideoUrl, $requestInstructorId, $requestDesc);

            $saved = $this->courseDatabase->save($course);

            \controllers\ControllerUtils::sendSuccessResponse(201, $saved);
        } catch (Exception $e) {
            $message = array(
                'message' => 'Failed to create course',
                'error' => $e->getMessage()
            );

            \controllers\ControllerUtils::sendErrorResponse(500, $message);
        }
    }

    // Update a course
    // PUT /neolearn-backend/index.php/courses
    public function update()
    {
        try {
            // Get the request body
            $requestBody = file_get_contents('php://input');

            // Make sure that the request body is not empty
            if (empty($requestBody)) {
                $message = array(
                    'message' => 'Failed to update course',
                    'error' => 'Request body is empty'
                );

                \controllers\ControllerUtils::sendErrorResponse(400, $message);
            }

            // Parse the request body as JSON
            $jsonRequestBody = json_decode($requestBody);

            // Get the id, name, videoUrl and instructorId from the request body
            $requestCourseId = $jsonRequestBody->id;
            $requestName = $jsonRequestBody->name;
            $requestVideoUrl = $jsonRequestBody->videoUrl;
            $requestInstructorId = $jsonRequestBody->instructorId;
            $requestDesc = $jsonRequestBody->description;

            // Check that the name exists
            $existingCourse = $this->courseDatabase->getById($requestCourseId);

            if ($existingCourse === null) {
                $message = array(
                    'message' => 'Failed to update course',
                    'error' => 'Course not found'
                );

                \controllers\ControllerUtils::sendErrorResponse(404, $message);
            }

            // Make sure that the name, videoUrl and instructorId are not empty
            if (empty($requestName) || empty($requestVideoUrl) || empty($requestInstructorId)) {
                $message = array(
                    'message' => 'Failed to create course',
                    'error' => 'Name, VideoUrl or InstructorId are empty'
                );

                \controllers\ControllerUtils::sendErrorResponse(400, $message);
            }

            // Now update the course
            $updatedCourse = new Course($requestName, $requestVideoUrl, $requestInstructorId, $requestDesc);
            $updatedCourse->setId($requestCourseId);

            $this->courseDatabase->update($updatedCourse);

            \controllers\ControllerUtils::sendSuccessResponse(200, $updatedCourse);
        } catch (Exception $e) {
            $message = array(
                'message' => 'Failed to update course',
                'error' => $e->getMessage()
            );

            \controllers\ControllerUtils::sendErrorResponse(500, $message);
        }
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