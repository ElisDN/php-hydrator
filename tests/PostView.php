<?php

namespace ElisDN\Hydrator\Tests;

class PostView
{
    public $public;
    protected $protected;
    private $private;

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