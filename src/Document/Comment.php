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
    public $id;
   /**
     * @MongoDB\Field(type="hash")
     */
    public $user;

    /**
     * @MongoDB\Field(type="string")
     */
    public $text;

    /**
     * @MongoDB\Field(type="bool")
     */
    public $top_level_comment;

    /**
     * @MongoDB\Field(type="collection")
     */
    public $replies;

    /**
     * @MongoDB\Field(type="string")
     */
    public $parent_id;

    public function setUser($arg): void
    {

      $this->user = [...$arg]; // TODO: Do we need to set this with array_push()?
    }

    public function setText($arg): void
    {
      $this->text = $arg;
    }

    public function setTopLevelComment($arg): void
    {
      $this->top_level_comment = $arg;
    }

    public function setReplies($arg): void
    {
      $this->replies = [...$arg];
    }

    public function setParentId($arg): void
    {
      $this->parent_id = $arg;
    }
}
