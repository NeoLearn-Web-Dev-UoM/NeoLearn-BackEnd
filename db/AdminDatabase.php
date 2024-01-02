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
        $sql = "SELECT * FROM admin WHERE id = '$id'";

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
        $dbUserPassword = $dbUser['password'];

        // Create a new User object and return it
        $user = new User($dbUserEmail, $dbUserPassword);
        $user->setId($dbUserId);

        return $user;
    }

    // GET (all)
    public function getAll()
    {
        $sql = "SELECT * FROM admin";
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
            $dbUserPassword = $dbUser['password'];

            // Create a new User object and add it to the array
            $user = new User($dbUserEmail, $dbUserPassword);
            $user->setId($dbUserId);

            $users[] = $user; // This adds the user to the array
        }

        // Return the array
        return $users;
    }

    // GET (by email)
    public function getByEmail($email) {
        $query = "SELECT * FROM admin WHERE email = '$email'";
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
        $dbUserPassword = $dbUser['password'];

        // Create a new User object and return it
        $user = new User($dbUserEmail, $dbUserPassword);
        $user->setId($dbUserId);

        return $user;
    }

    // INSERT
    public function save(Admin $newAdmin)
    {
        $email = $newAdmin->getEmail();
        $password = $newAdmin->getPassword();

        $query = "INSERT INTO admin (email, password) VALUES ('$email', '$password')";

        $queryResult = mysqli_query($this->dbConnection, $query);

        if (!$queryResult) {
            $sqlError = mysqli_error($this->dbConnection);
            throw new Exception($sqlError);
            return null;
        }

        // We get to this point if the query managed to execute.
        return $newAdmin;
    }

    // UPDATE
    public function update(Admin $updateAdmin)
    {
        // Get the values from the user object
        $userId = $updateAdmin->getId();
        $email = $updateAdmin->getEmail();
        $password = $updateAdmin->getPassword();

        $query = "UPDATE admin SET email = '$email', password = '$password' WHERE id = '$userId'";
        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return null; }

        // We get to this point only if the query executed successfully.
        return $updateAdmin;
    }

    // DELETE
    public function delete(Admin $adminIdToDelete)
    {
        $query = "DELETE FROM admin WHERE id = '$adminIdToDelete'";

        $result = mysqli_query($this->dbConnection, $query);

        // Check if the query failed
        if (!$result) { return false; }

        // We get to this point only if the query executed successfully.
        return true;
    }

    // Add any other methods you need
}