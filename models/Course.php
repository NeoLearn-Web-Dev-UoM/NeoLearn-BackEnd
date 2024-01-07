<?php
class Course implements JsonSerializable
{
    private $id;
    private $name;
    private $videoUrl;
    private $instructorId;
    private $description;

    public function __construct($name, $videoUrl, $instructorId,$description)
    {
        $this->name = $name;
        $this->videoUrl = $videoUrl;
        $this->instructorId = $instructorId;
        $this->description = $description;
    }

    public function getId()
    { return $this->id; }

    public function getName()
    { return $this->name; }

    public function getVideoUrl()
    { return $this->videoUrl; }

    public function getInstructorId()
    { return $this->instructorId; }

    public function getDescription()
    { return $this->description; }

    public function setId($id){
        $this->id = $id;
    }

    public function setName($name)
    { $this->name = $name; }

    public function setVideoUrl($videoUrl)
    { $this->videoUrl = $videoUrl; }

    public function setDescription($description){
        $this->description = $description;
    }

    public function setInstructorId($instructorId)
    { $this->instructorId = $instructorId; }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'videoUrl' => $this->videoUrl,
            'instructorId' => $this->instructorId,
            'description' => $this->description
        ];
    }

    public function __toString()
    {
        return $this->id. " | " .$this->name . " | " . $this->videoUrl . " | " . $this->instructorId . " | " . $this->description;
    }
}