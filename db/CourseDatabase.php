<?php
class CourseDatabase
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // The methods below have the same logic as the ones in the StudentDatabase
    // The only difference is that we are using the Course model instead of the Student model
    // So we will use the course table instead of the student table
    // We will use this class on the controllers
    // (See: StudentDatabase.php and StudentController.php)

    // GET (by id)
    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    // GET (all)
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    // INSERT
    public function save(Course $course)
    {
        // TODO: Implement save() method.
    }

    // UPDATE
    public function update(Course $course)
    {
        // TODO: Implement update() method.
    }

    // DELETE
    public function delete(Course $course)
    {
        // TODO: Implement delete() method.
    }

    // Add any other methods you need
}