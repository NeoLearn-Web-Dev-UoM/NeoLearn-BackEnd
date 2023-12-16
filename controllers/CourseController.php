<?php
// The logic here is the same as the other controllers

class CourseController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Get all courses
    // GET /neolearn-backend/index.php/courses
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    // Get a course by id
    // GET /neolearn-backend/index.php/courses/search/id/{courseId}
    public function getById($courseId)
    {
        // TODO: Implement getById() method.
    }

    // Get courses by instructor id
    // GET /neolearn-backend/index.php/courses/search/instructor/{instructorId}
    public function getByInstructorId($instructorId)
    {
        // TODO: Implement getByInstructorId() method.
    }

    // Create a new course
    // POST /neolearn-backend/index.php/courses
    public function createCourse()
    {
        // TODO: Implement createCourse() method.
    }

    // Update a course
    // PUT /neolearn-backend/index.php/courses
    public function update()
    {
        // TODO: Implement update() method.
    }

    // Delete a course
    // DELETE /neolearn-backend/index.php/courses/delete/{courseId}
    public function delete($courseId)
    {
        // TODO: Implement delete() method.
    }
}