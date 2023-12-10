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
}