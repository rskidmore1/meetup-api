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
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    public $name;

    /**
     * @MongoDB\Field(type="array")
     */
    public $user;

    /**
     * @MongoDB\Field(type="string")
     */
    public $text;

    /**
     * @MongoDB\Field(type="boolean")
     */
    public $top_level_comment;

    /**
     * @MongoDB\Field(type="array")
     */
    public $replies;

    public function setName($arg): void
    {
      $this->name = $arg;
    }

    public function setPrice($arg): void
    {
      $this->price = $arg;
    }
}
