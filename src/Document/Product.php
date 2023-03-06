<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Product
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
     * @MongoDB\Field(type="float")
     */
    public $price;

    public function setName($arg): void
    {
      $this->name = $arg;
    }

    public function setPrice($arg): void
    {
      $this->price = $arg;
    }
}
