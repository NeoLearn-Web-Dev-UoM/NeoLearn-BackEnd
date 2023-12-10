<?php
class Course implements JsonSerializable
{
    private $id;
    private $name;
    private $description;
    private $instructorId;

    public function __construct($id, $name, $description, $instructorId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->instructorId = $instructorId;
    }

    public function getId()
    { return $this->id; }

    public function getName()
    { return $this->name; }

    public function getDescription()
    { return $this->description; }

    public function getInstructorId()
    { return $this->instructorId; }

    public function setName($name)
    { $this->name = $name; }

    public function setDescription($description)
    { $this->description = $description; }

    public function setInstructorId($instructorId)
    { $this->instructorId = $instructorId; }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'instructorId' => $this->instructorId
        ];
    }

    public function __toString()
    {
        return $this->id. " | " .$this->name . " | " . $this->description . " | " . $this->instructorId;
    }
}