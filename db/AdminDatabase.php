<?php

class AdminDatabase
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // The methods below have the same logic as the ones in the StudentDatabase
    // The only difference is that we are using the Admin model instead of the Student model
    // So we will use the admin table instead of the student table
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
    public function save(Admin $admin)
    {
        // TODO: Implement save() method.
    }

    // UPDATE
    public function update(Admin $admin)
    {
        // TODO: Implement update() method.
    }

    // DELETE
    public function delete(Admin $admin)
    {
        // TODO: Implement delete() method.
    }

    // Add any other methods you need
}