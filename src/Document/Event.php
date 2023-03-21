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
     * @MongoDB\Field(type="collection")
     */
    public $hosts;

    /**
     * @MongoDB\Field(type="string")
     */
    public $location; // @todo: change type to somethign else if neeed

    /**
     * @MongoDB\Field(type="string")
     */
    public $details_paragraph;

    /**
     * @MongoDB\Field(type="string")
     */
    public $start_time; // @todo: change type to timestamp

    /**
     * @MongoDB\Field(type="string")
     */
    public $end_time; // @todo: change type to timestamp

    // @todo: create groupID
    // /**
    //  * @MongoDB\Id
    //  */
    // public $groupId;

    public function setTitle($arg): void
    {

      $this->title = $arg;
    }

    public function setHosts($arg): void
    {
      $this->hosts = $arg;
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
