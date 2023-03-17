<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Comment
{
    /**
     * @MongoDB\Id
     */
    public $id; // @TODO: set all these to protected and make sure it works

    /**
     * @MongoDB\Field(type="string")
     */
    public $name;
    /**
     * @MongoDB\Field(type="string")
     */
    public $picture;
    /**
     * @MongoDB\Field(type="string")
     */
    public $description;
    /**
     * @MongoDB\Field(type="string")
     */
    public $location;

    public function setName($arg): void
    {

      $this->name = $arg;
    }

    public function setPicture($arg): void
    {
      $this->picture = $arg;
    }

    public function setDescription($arg): void
    {
      $this->description = $arg;
    }

    public function setLocation($arg): void
    {
      $this->location = $arg;
    }
}
