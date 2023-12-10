<?php

class AdminDatabase
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
    public function save(Admin $admin)
    {
        // TODO: Implement save() method.
    }

    // UPDATE
    public function update(Admin $admin)
    {
        // TODO: Implement update() method.
    }
}