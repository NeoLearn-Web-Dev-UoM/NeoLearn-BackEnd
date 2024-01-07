<?php
class CourseDatabase
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // GET (by id)
    public function getById($id)
    {
        $sql = "SELECT * FROM course WHERE id = '$id'";

        $result = mysqli_query($this->dbConnection, $sql);

        // Check if the query failed
        if (!$result) {
            throw new Exception('Database error: ' . mysqli_error($this->dbConnection));
        }

        // If the query returned 0 rows return null (no user found)
        if (mysqli_num_rows($result) === 0) {
            return null;
        }

        $dbCourse = mysqli_fetch_assoc($result);  // This will return an associative array

        // Now we need to turn this array into a Course object
        // Get the values from the array
        $dbCourseId = $dbCourse['id'];
        $dbCourseName = $dbCourse['name'];
        $dbCourseInstructorId = $dbCourse['instructor_id'];
        $dbCourseVideoUrl = $dbCourse['video_url'];

        // Create a new Course object and return it
        $course = new Course($dbCourseName, $dbCourseVideoUrl, $dbCourseInstructorId, "");
        $course->setId($dbCourseId);

        return $course;
    }

    // GET (all)
    public function getAll()
    {
        $sql = "SELECT * FROM course";
        $result = mysqli_query($this->dbConnection, $sql);

        // show why the query failed
        if (!$result) {
            throw new Exception('Database error: ' . mysqli_error($this->dbConnection));
        }

        // Check if the query returned any rows if it does return an empty array
        if (mysqli_num_rows($result) === 0) {
            return [];
        }

        // We will get to this point only if the query returned rows

        // Create an empty array
        $courses = [];

        // db result is an array of arrays
        $dbResult = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Loop through the db result array and turn each item into a Course object
        foreach ($dbResult as $dbCourse) {
            // Get the values from the array
            $dbCourseId = $dbCourse['id'];
            $dbCourseName = $dbCourse['name'];
            $dbCourseInstructorId = $dbCourse['instructor_id'];
            $dbCourseVideoUrl = $dbCourse['video_url'];
            $dbCourseDescription = $dbCourse['description'];

            // Create a new Course object and add it to the array
            $course = new Course($dbCourseName, $dbCourseVideoUrl, $dbCourseInstructorId, $dbCourseDescription);
            $course->setId($dbCourseId);

            $courses[] = $course; // This adds the course to the array
        }

        return $courses;
    }

    public function getByName($name) {
        $query = "SELECT * FROM course WHERE name = '$name'";
        $queryResult = mysqli_query($this->dbConnection, $query);

        if (!$queryResult) {
            throw new Exception('Database error: ' . mysqli_error($this->dbConnection));
        }

        if (mysqli_num_rows($queryResult) === 0) {
            return [];
        }

        // We will get to this point only if the query returned rows

        // Create an empty array
        $courses = [];

        // db result is an array of arrays
        $dbResult = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

        // Loop through the db result array and turn each item into a Course object
        foreach ($dbResult as $dbCourse) {
            // Get the values from the array
            $dbCourseId = $dbCourse['id'];
            $dbCourseName = $dbCourse['name'];
            $dbCourseInstructorId = $dbCourse['instructor_id'];
            $dbCourseVideoUrl = $dbCourse['video_url'];
            $dbCourseDescription = $dbCourse['description'];

            // Create a new Course object and add it to the array
            $course = new Course($dbCourseName, $dbCourseVideoUrl, $dbCourseInstructorId, $dbCourseDescription);
            $course->setId($dbCourseId);

            $courses[] = $course; // This adds the course to the array
        }

        return $courses;
    }

    public function getByInstructorId($id) {
        $query = "SELECT * FROM course WHERE instructor_id = '$id'";

        $queryResult = mysqli_query($this->dbConnection, $query);

        if (!$queryResult) {
            throw new Exception('Database error: ' . mysqli_error($this->dbConnection));
        }

        if (mysqli_num_rows($queryResult) === 0) {
            return [];
        }

        // We will get to this point only if the query returned rows

        // Create an empty array
        $courses = [];

        // db result is an array of arrays
        $dbResult = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

        // Loop through the db result array and turn each item into a Course object
        foreach ($dbResult as $dbCourse) {
            // Get the values from the array
            $dbCourseId = $dbCourse['id'];
            $dbCourseName = $dbCourse['name'];
            $dbCourseInstructorId = $dbCourse['instructor_id'];
            $dbCourseVideoUrl = $dbCourse['video_url'];
            $dbCourseDescription = $dbCourse['description'];

            // Create a new Course object and add it to the array
            $course = new Course($dbCourseName, $dbCourseVideoUrl, $dbCourseInstructorId, $dbCourseDescription);
            $course->setId($dbCourseId);

            $courses[] = $course; // This adds the course to the array
        }

        return $courses;
    }

    // INSERT
    public function save(Course $newCourse) {
        $name = $newCourse->getName();
        $videoUrl = $newCourse->getVideoUrl();
        $instructorId = $newCourse->getInstructorId();
        $courseDescription = $newCourse->getDescription();

        $query = "INSERT INTO course (name, video_url, instructor_id, description) VALUES ('$name', '$videoUrl', '$instructorId', '$courseDescription')";

        $queryResult = mysqli_query($this->dbConnection, $query);

        if (!$queryResult) {
            throw new Exception('Database error: ' . mysqli_error($this->dbConnection));
        }

        $newCourseId = mysqli_insert_id($this->dbConnection);
        $newCourse->setId($newCourseId);

        // We get to this point if the query managed to execute.
        return $newCourse;
    }

    // UPDATE
    public function update(Course $updatedCourse) {
        // Get the values from the course object
        $courseId = $updatedCourse->getId();
        $courseName = $updatedCourse->getName();
        $courseVideoUrl = $updatedCourse->getVideoUrl();
        $courseInstructorId = $updatedCourse->getInstructorId();
        $courseDescription = $updatedCourse->getDescription();

        $query = "UPDATE course SET name = '$courseName', video_url = '$courseVideoUrl', instructor_id = '$courseInstructorId', description = '$courseDescription' WHERE id = '$courseId'";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) {
            throw new Exception('Database error: ' . mysqli_error($this->dbConnection));
        }

        // We get to this point only if the query executed successfully.
        return $updatedCourse;
    }

    // DELETE
    public function delete($courseIdToDelete) {
        $query = "DELETE FROM course WHERE id = '$courseIdToDelete'";

        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) {
            throw new Exception('Database error: ' . mysqli_error($this->dbConnection));
        }

        // We get to this point only if the query executed successfully.
        $msg = "Course with id $courseIdToDelete was deleted successfully";

        return $msg;
    }
}