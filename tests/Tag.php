<?php

namespace ElisDN\Hydrator\Tests;

class Tag
{
    public $public;
    protected $protected;
    private $private;

    public function __construct($public, $protected, $private)
    {
        $this->public = $public;
        $this->protected = $protected;
        $this->private = $private;
    }

    public function getPublic()
    {
        return $this->public;
    }

    public function getProtected()
    {
        return $this->protected;
    }

    public function getPrivate()
    {
        return $this->private;
    }
}