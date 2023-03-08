<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Event
{
    /**
     * @MongoDB\Id
     */
    private $id;
   /**
     * @MongoDB\Field(type="string")
     */
    public $title;

    /**
     * @MongoDB\Field(type="string")
     */
    public $host;

    /**
     * @MongoDB\Field(type="string")
     */
    public $host_photo;

    /**
     * @MongoDB\Field(type="string")
     */
    public $location; // @todo: change type to somethign else if neeed

    /**
     * @MongoDB\Field(type="string")
     */
    public $details_paragraph;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    public $start_time;

    /**
     * @MongoDB\Field(type="timestamp")
     */
    public $end_time;

    /**
     * @MongoDB\Id
     */
    public $group;

    public function setTitle($arg): void
    {

      $this->title = $arg;
    }

    public function setHost($arg): void
    {
      $this->host = $arg;
    }

    public function setHostPhoto($arg): void
    {
      $this->host_photo = $arg;
    }

    public function setPhoto($arg): void
    {
      $this->photo = $arg;
    }

    public function setLocation($arg): void
    {
      $this->location = $arg;
    }

    public function setDetailsParagraph($arg): void
    {
      $this->details_paragraph = $arg;
    }

    public function setStartTime($arg): void
    {
      $this->start_time = $arg;
    }

    public function setEndTime($arg): void
    {
      $this->end_time = $arg;
    }

    public function setGroup($arg): void
    {
      $this->group = $arg;
    }
}
