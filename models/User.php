<?php

class User implements JsonSerializable
{
    private $id;
    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getId()
    { return $this->id; }

    public function getEmail()
    { return $this->email; }

    public function getPassword()
    { return $this->password; }

    public function setEmail($email)
    { $this->email = $email; }

    public function setPassword($password)
    { $this->password = $password; }

    public function setId($id)
    { $this->id = $id; }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function __toString()
    {
        return $this->id. " | " .$this->email . " | " . $this->password;
    }
}