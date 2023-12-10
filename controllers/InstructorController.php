<?php

require_once 'models/Instructor.php';
require_once 'db/InstructorDatabase.php';

class InstructorController
{
    private $instructorDatabase;

    public function __construct($conn)
    {
        $this->instructorDatabase = new InstructorDatabase($conn);
    }

    // GET (by all)
    // GET - /instructors/
    public function getAll() {
        // TODO: Implement getAll() method.
    }

    // Add any other methods you need
    // each method should corespond to one of the endpoints in the API
    // The endpoints are defined in the file: index.php
    // The approach is very similar to the one we used in the StudentController
    // The only difference is that we are using the InstructorDatabase instead of the StudentDatabase
    // So we will use the methods from the InstructorDatabase
}