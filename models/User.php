<?php

class User implements JsonSerializable
{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($email, $name, $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    public function getId()
    { return $this->id; }

    public function getName()
    { return $this->name; }

    public function getEmail()
    { return $this->email; }

    public function getPassword()
    { return $this->password; }

    public function setEmail($email)
    { $this->email = $email; }

    public function setName($name)
    { $this->name = $name; }

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
            'name' => $this->name
        ];
    }

    public function __toString()
    {
        return $this->id. " | " .$this->email . " | ". $this->name . " | " . $this->password;
    }
}