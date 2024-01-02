<?php

class StudentDatabase
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // GET All
    public function getAll()
    {
        $sql = "SELECT * FROM student";
        $result = mysqli_query($this->dbConnection, $sql);

        // Check if the query failed
        if (!$result) { return null; }

        // Check if the query returned any rows if it does return an empty array
        if (mysqli_num_rows($result) === 0) { return []; }

        // We will get to this point only if the query returned rows

        // Create an empty array
        $users = [];

        // db result is an array of arrays
        $dbResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Loop through the db result array and turn each item into a User object
        foreach ($dbResult as $dbUser) {
            // Get the values from the array
            $dbUserId = $dbUser['id'];
            $dbUserEmail = $dbUser['email'];
            $dbUserName = $dbUser['name'];
            $dbUserPassword = $dbUser['password'];

            // Create a new User object and add it to the array
            $user = new Student($dbUserEmail, $dbUserName, $dbUserPassword);
            $user->setId($dbUserId);

            $users[] = $user; // This adds the user to the array
        }

        // Return the array
        return $users;
    }

    // GET (by id)
    public function getById($id)
    {
        $sql = "SELECT * FROM student WHERE id = '$id'";

        $result = mysqli_query($this->dbConnection, $sql);

        // Check if the query failed
        if (!$result) { return null; }

        // If the query returned 0 rows return null (no user found)
        if (mysqli_num_rows($result) === 0) { return null; }

        $dbUser = mysqli_fetch_assoc($result);  // This will return an associative array

        // Now we need to turn this array into a User object
        // Get the values from the array
        $dbUserId = $dbUser['id'];
        $dbUserEmail = $dbUser['email'];
        $dbUserName = $dbUser['name'];
        $dbUserPassword = $dbUser['password'];

        // Create a new User object and return it
        $user = new User($dbUserEmail, $dbUserName, $dbUserPassword);
        $user->setId($dbUserId);

        return $user;
    }

    // GET (by email)
    public function getByEmail($email) {
        $query = "SELECT * FROM student WHERE email = '$email'";
        $queryResult = mysqli_query($this->dbConnection, $query);

        // if the query failed return null
        if (!$queryResult) { return null; }

        // if the query returned 0 rows return null
        if (mysqli_num_rows($queryResult) === 0) { return null; }

        $dbUser = mysqli_fetch_assoc($queryResult); // This will return an associative array

        // Now we need to turn this array into a User object
        // Get the values from the array
        $dbUserId = $dbUser['id'];
        $dbUserEmail = $dbUser['email'];
        $dbUserName = $dbUser['name'];
        $dbUserPassword = $dbUser['password'];

        // Create a new User object and return it
        $user = new User($dbUserEmail, $dbUserName, $dbUserPassword);
        $user->setId($dbUserId);

        return $user;
    }

    // INSERT
    public function save(Student $newStudent) {
        $email = $newStudent->getEmail();
        $name = $newStudent->getName();
        $password = $newStudent->getPassword();

        $query = "INSERT INTO student (email, password, name) VALUES ('$email', '$password', '$name')";

        $queryResult = mysqli_query($this->dbConnection, $query);

        if (!$queryResult) {
            $sqlError = mysqli_error($this->dbConnection);
            throw new Exception($sqlError);
            return null;
        }

        // We get to this point if the query managed to execute.
        return $newStudent;
    }

    // UPDATE
    public function update(Student $updatedStudent) {
        // Get the values from the user object
        $userId = $updatedStudent->getId();
        $email = $updatedStudent->getEmail();
        $name = $updatedStudent->getName();
        $password = $updatedStudent->getPassword();

        $query = "UPDATE student SET email = '$email', password = '$password', name = '$name' WHERE id = '$userId'";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return null; }

        // We get to this point only if the query executed successfully.
        return $updatedStudent;
    }

    // DELETE
    public function delete($studentIdToDelete) {
        $query = "DELETE FROM student WHERE id = '$studentIdToDelete'";

        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return false; }

        // We get to this point only if the query executed successfully.
        return true;
    }

    // ADD COURSE TO STUDENT
    // For this I will use the StudentHasCourse object
    public function addCourseToStudent($studentId, $courseId) {
        // We will get to this point only if the student and course exist.
        $query = "INSERT INTO student_has_courses (student_id, course_id) VALUES ('$studentId', '$courseId')";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return false; }

        // We get to this point only if the query executed successfully.
        return true;
    }

    // REMOVE COURSE FROM STUDENT
    // For this I will use the StudentHasCourse object
    public function removeCourseFromStudent($studentId, $courseId) {
        // We will get to this point only if the student and course exist.
        $query = "DELETE FROM student_has_courses WHERE student_id = '$studentId' AND course_id = '$courseId'";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return false; }

        // We get to this point only if the query executed successfully.
        return true;
    }

    // GET ALL COURSES FOR STUDENT
    // TODO: Fix the Course constructor
    public function getAllCoursesForStudent($studentId) {
        // We will get to this point only if the student exists.
        $query = "SELECT * FROM student_has_courses WHERE student_id = '$studentId'";

        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return null; }

        // Check if the query returned no rows if it does return an empty array
        if (mysqli_num_rows($result) === 0) { return []; }

        // We will get to this point only if the query returned rows

        $courses = [];  // Create an empty array

        // db result is an array of arrays
        $dbResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Loop through the db result array and turn each item into a Course object
        foreach ($dbResult as $dbCourse) {
            // Get the values from the array
            $dbCourseId = $dbCourse['course_id'];

            $videoURL = null;
            // Create a new Course object and add it to the array
            $course = new Course($dbCourseId);

            $courses[] = $course; // This adds the course to the array
        }

        // Return the array
        return $courses;
    }
}