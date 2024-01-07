<?php

class InstructorDatabase
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // GET (by id)
    public function getById($id)
    {
        $sql = "SELECT * FROM instructor WHERE id = '$id'";

        $result = mysqli_query($this->dbConnection, $sql);

        // Check if the query failed
        if (!$result) { return null; }

        // If the query returned 0 rows return null (no user found)
        if (mysqli_num_rows($result) === 0) { return null; }

        $dbInstructor = mysqli_fetch_assoc($result);  // This will return an associative array

        // Now we need to turn this array into a User object
        // Get the values from the array
        $dbInstructorId = $dbInstructor['id'];
        $dbInstructorEmail = $dbInstructor['email'];
        $dbInstructorName = $dbInstructor['name'];
        $dbInstructorPassword = $dbInstructor['password'];

        // Create a new Instructor object and return it
        $instructor = new Instructor($dbInstructorEmail, $dbInstructorName, $dbInstructorPassword);
        $instructor->setId($dbInstructorId);

        return $instructor;
    }

    // GET (by email)
    public function getByEmail($email) {
        $query = "SELECT * FROM instructor WHERE email = '$email'";
        $queryResult = mysqli_query($this->dbConnection, $query);

        // if the query failed return null
        if (!$queryResult) { return null; }

        // if the query returned 0 rows return null
        if (mysqli_num_rows($queryResult) === 0) { return null; }

        $dbInstructor = mysqli_fetch_assoc($queryResult); // This will return an associative array

        // Now we need to turn this array into a User object
        // Get the values from the array
        $dbInstructorId = $dbInstructor['id'];
        $dbInstructorEmail = $dbInstructor['email'];
        $dbInstructorName = $dbInstructor['name'];
        $dbInstructorPassword = $dbInstructor['password'];

        // Create a new User object and return it
        $instructor = new Instructor($dbInstructorName, $dbInstructorEmail, $dbInstructorPassword);
        $instructor->setId($dbInstructorId);

        return $instructor;
    }

    // GET (all)
    public function getAll()
    {
        // Create an empty array
        $instructors = [];

        $sql = "SELECT * FROM instructor";
        $result = mysqli_query($this->dbConnection, $sql);

        if (!$result) { return null; }  // Check if the query failed

        // Check if the query returned any rows if it does return an empty array
        if (mysqli_num_rows($result) === 0) { return $instructors; }

        // We will get to this point only if the query returned rows

        // db result is an array of arrays
        $dbResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Loop through the db result array and turn each item into a User object
        foreach ($dbResult as $dbInstructor) {
            // Get the values from the array
            $dbInstructorId = $dbInstructor['id'];
            $dbInstructorEmail = $dbInstructor['email'];
            $dbInstructorName = $dbInstructor['name'];
            $dbInstructorPassword = $dbInstructor['password'];

            // Create a new Instructor object and add it to the array
            $instructor = new Instructor($dbInstructorEmail, $dbInstructorName, $dbInstructorPassword);
            $instructor->setId($dbInstructorId);

            $instructors[] = $instructor; // This adds the instructors to the array
        }

        // Return the array
        return $instructors;
    }

   // INSERT
   public function save(Instructor $newInstructor) {
        $email = $newInstructor->getEmail();
        $password = $newInstructor->getPassword();
        $name = $newInstructor->getName();

        $query = "INSERT INTO instructor (email, password, name) VALUES ('$email', '$password', '$name')";

        $queryResult = mysqli_query($this->dbConnection, $query);

        if (!$queryResult) {
            $sqlError = mysqli_error($this->dbConnection);
            throw new Exception($sqlError);
        }

        // Get the id of the new instructor (this gets the last inserted id from the dbConnection)
        $newInstructorId = mysqli_insert_id($this->dbConnection);
        $newInstructor->setId($newInstructorId);

        // We get to this point if the query managed to execute.
        return $newInstructor;
    }

    // UPDATE
    public function update(Instructor $updatedInstructor) {
        // Get the values from the instructor object
        $userId = $updatedInstructor->getId();
        $email = $updatedInstructor->getEmail();
        $name = $updatedInstructor->getName();
        $password = $updatedInstructor->getPassword();

        $query = "UPDATE instructor SET email = '$email', password = '$password', name = '$name' WHERE id = '$userId'";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return null; }

        // We get to this point only if the query executed successfully.
        return $updatedInstructor;
    }

    // DELETE
    public function delete($instructorIdToDelete) {
        $query = "DELETE FROM instructor WHERE id = '$instructorIdToDelete'";

        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return false; }

        // We get to this point only if the query executed successfully.
        return true;
    }

    //GET_COURSES
    // GET ALL COURSES FOR INSTRUCTOR
    public function getAllCoursesForInstructor($instructorId) {
        // We will get to this point only if the instructor exists.
        $query = "SELECT * FROM courses WHERE instructor_id = '$instructorId'";

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

            // Create a new Course object and add it to the array
            $course = new Course($dbCourseId);

            $courses[] = $course; // This adds the course to the array
        }

        // Return the array
        return $courses;
    }

     // ADD COURSE TO INSTRUCTOR
    public function addCourseToInstructor($instructorId, $courseId) {
        // We will get to this point only if the instructor and course exist.
        $query = "INSERT INTO courses (instructor_id) WHERE course_id='$courseId' VALUES ('$instructorId')";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return false; }

        // We get to this point only if the query executed successfully.
        return true;
    }

       // REMOVE COURSE FROM INSTRUCTOR
    public function removeCourseFromInstructor($instructorId, $courseId) {
        // We will get to this point only if the instructor and course exist.
        $query = "DELETE FROM courses WHERE instructor_id = '$instructorId'";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return false; }

        // We get to this point only if the query executed successfully.
        return true;
    }

}