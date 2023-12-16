<?php

class Instructor extends User implements jsonSerializable
{

    public function __construct($email, $password)
    {
        parent::__construct($email, $password);
    }

}
