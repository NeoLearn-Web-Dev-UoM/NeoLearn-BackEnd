<?php

require_once 'db/StudentDatabase.php';
require_once 'db/InstructorDatabase.php';
require_once 'controllers/ControllerUtils.php';

use controllers\ControllerUtils;

class AuthenticationController
{
    private $studentDatabase;
    private $instructorDatabase;

    public static $STUDENT = 'student';
    public static $INSTRUCTOR = 'instructor';

    public static $ADMIN = 'admin';

    public function __construct($conn)
    {
        $this->studentDatabase = new StudentDatabase($conn);
        $this->instructorDatabase = new InstructorDatabase($conn);
    }

    /**
     * This method is used to select the correct database based on the user type
     * To prevent errors related to typos we will always use the constants defined in this class [$STUDENT, $INSTRUCTOR etc]
     */
    private function selectDatabase($userType) {
        if ($userType === AuthenticationController::$STUDENT) return $this->studentDatabase;

        else if ($userType === AuthenticationController::$INSTRUCTOR) return $this->instructorDatabase;

        // TODO: Add the admin database here
        else if ($userType === AuthenticationController::$ADMIN) return null;

        // We will get here if the user type is not valid. throw an exception
        throw new Exception('Invalid user type');
    }

    /**
     * This method is a generic login method that can be used for both students and instructors
     * We provide the user type as a parameter to select the correct database
     * To prevent errors related to typos we will always use the constants defined in this class [$STUDENT, $INSTRUCTOR etc]
     */
    public function loginUser($email, $pass, $userType) {
        $dbToUse = $this->selectDatabase($userType);
        $user = $dbToUse->getByEmail($email);

        $userNotFound = $user === null;
        if ($userNotFound) ControllerUtils::sendErrorResponse(401, 'User with email ' . $email . ' not found');

        $storedPassword = $user->getPassword();
        $passwordsMatch = password_verify($pass, $storedPassword);

        $passwordIsIncorrect = !$passwordsMatch;
        if ($passwordIsIncorrect) ControllerUtils::sendErrorResponse(401, 'Incorrect password');

        // If we get to this point the user exists and the password is correct
        ControllerUtils::sendSuccessResponse(200, $user);
    }

    /**
     * This method is used to extract the login details from the request body
     * We will use this method in both loginStudent() and loginInstructor()
     */
    public function extractLoginDetails() {
        // Get the Login details from the request body
        $requestBody = file_get_contents('php://input');

        // Decode the JSON object
        $loginDetails = json_decode($requestBody);

        // Get the email and password from the decoded object
        $givenEmail = $loginDetails->email;
        $givenPassword = $loginDetails->password;

        return [$givenEmail, $givenPassword];
    }

    // LOGIN FOR STUDENT
    public function loginStudent() {
        // Get the Login details from the request body
        list($givenEmail, $givenPassword) = $this->extractLoginDetails();

        $this->loginUser($givenEmail, $givenPassword, AuthenticationController::$STUDENT);
    }

    // LOGIN FOR INSTRUCTOR
    public function loginInstructor() {
        // Get the Login details from the request body
        list($givenEmail, $givenPassword) = $this->extractLoginDetails();

        $this->loginUser($givenEmail, $givenPassword, AuthenticationController::$INSTRUCTOR);
    }

    // LOGIN FOR ADMIN
    public function loginAdmin() {
        // Get the Login details from the request body
        list($givenEmail, $givenPassword) = $this->extractLoginDetails();

        $this->loginUser($givenEmail, $givenPassword, AuthenticationController::$ADMIN);
    }
}