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
   public $name;
   /**
     * @MongoDB\Field(type="string")
     */
   public $picture;
   /**
     * @MongoDB\Field(type="string")
     */
   public $location;
   /**
     * @MongoDB\Field(type="string")
     */
   public $joined_date;
   /**
     * @MongoDB\Field(type="string")
     */
   public $last_visited_date;
   /**
     * @MongoDB\Field(type="string")
     */
   public $age;
   /**
     * @MongoDB\Field(type="string")
     */
   public $introduction;
   /**
     * @MongoDB\Field(type="string")
     */
   public $activity_interests;
   /**
     * @MongoDB\Field(type="collection")
     */
   public $groups;


    public function setName($arg): void
    {

      $this->name = $arg;
    }
    public function setPicture($arg): void
    {

      $this->picture = $arg;
    }
    public function setLocation($arg): void
    {

      $this->location = $arg;
    }
    public function setJoinedDate($arg): void
    {

      $this->joined_date = $arg;
    }
    public function setLastVisitedDate($arg): void
    {

      $this->last_visited_date = $arg;
    }
    public function setAge($arg): void
    {

      $this->age = $arg;
    }
    public function setIntroduction($arg): void
    {

      $this->introduction = $arg;
    }
    public function setActivityInterests($arg): void
    {

      $this->activity_interests = $arg;
    }
    public function setGroup($arg): void
    {

      $this->group = [...$arg];
    }

}
