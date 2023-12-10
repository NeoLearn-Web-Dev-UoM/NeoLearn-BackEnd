<?php

require_once 'db/StudentDatabase.php';
require_once 'db/InstructorDatabase.php';

class AuthenticationController
{
    private $studentDatabase;
    private $instructorDatabase;

    public function __construct($conn)
    {
        $this->studentDatabase = new StudentDatabase($conn);
        $this->instructorDatabase = new InstructorDatabase($conn);
    }

    // LOGIN FOR STUDENT
    public function loginStudent() {
        // Get the Login details from the request body
        $requestBody = file_get_contents('php://input');

        // Decode the JSON object
        $loginDetails = json_decode($requestBody);

        // Get the email and password from the decoded object
        $givenEmail = $loginDetails->email;
        $givenPassword = $loginDetails->password;

        // Get the student from the database
        $student = $this->studentDatabase->getByEmail($givenEmail);

        // Check if the student exists
        if ($student === null) {
            header('Content-Type: application/json');
            http_response_code(404);

            $response = [
                'message' => 'Student not with email ' . $givenEmail . ' not found'
            ];

            echo json_encode($response);

            // Stop the execution of the script
            return;
        }

        // Check if the password is correct
        // we used password_hash() to hash the password when we created the user
        // we will use password_verify() to compare the given password with the hashed password

        // Get the hashed password we have stored in the database
        $storedPassword = $student->getPassword();

        if (!password_verify($givenPassword, $storedPassword)) {
            header('Content-Type: application/json');
            http_response_code(401);

            $response = [
                'message' => 'Incorrect password'
            ];

            echo json_encode($response);

            // Stop the execution of the script
            return;
        }

        // If we get to this point the user exists and the password is correct

        // We will return the user so the front-end can use the user's details
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($student);
    }

    // LOGIN FOR INSTRUCTOR
    public function loginInstructor() {
        // TODO: Implement loginInstructor() method.
        // The logic should be pretty much the same as the loginStudent() method
    }
}