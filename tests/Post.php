<?php

namespace ElisDN\Hydrator\Tests;

class Post
{
    public $public;
    protected $protected;
    private $private;

    public function __construct()
    {
        throw new \BadMethodCallException('');
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