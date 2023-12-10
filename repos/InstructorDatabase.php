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
        // TODO: Implement getById() method.
    }

    // GET (by email)
    public function getByEmail($email)
    {
        // TODO: Implement getByEmail() method.
    }

    // GET (all)
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    // INSERT
    public function save(Instructor $instructor)
    {
        // TODO: Implement save() method.
    }

    // UPDATE
    public function update(Instructor $instructor)
    {
        // TODO: Implement update() method.
    }

    // DELETE
    public function delete(Instructor $instructor)
    {
        // TODO: Implement delete() method.
    }
}