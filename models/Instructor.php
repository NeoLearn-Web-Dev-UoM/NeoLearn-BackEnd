<?php

class Instructor extends User implements jsonSerializable
{

    public function __construct($email, $password, $course)
    {
        parent::__construct($email, $password);
    }

}
