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
    public $parent_object_id;

    /**
     * @MongoDB\Field(type="string")
     */
    public $parent_comment_id;

    public function setUser($arg): void
    {

      $this->user = [...$arg];
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

    public function setParentObjectId($arg): void
    {
      $this->parent_object_id = $arg;
    }

    public function setParentCommentId($arg): void
    {
      $this->parent_comment_id = $arg;
    }
}
