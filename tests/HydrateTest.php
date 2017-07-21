<?php
/**
 * This file is part of the elisdn/php-hydrator library
 *
 * @copyright Copyright (c) Dmitry Eliseev <mail@elisdn.ru>
 * @license https://github.com/ElisDN/php-hydrator/blob/master/LICENSE.md
 * @link https://github.com/ElisDN/php-hydrator
 */

namespace ElisDN\Hydrator\Tests;

use ElisDN\Hydrator\Hydrator;
use PHPUnit\Framework\TestCase;

class HydrateTest extends TestCase
{
    /**
     * @var Hydrator
     */
    private $hydrator;

    public function setUp()
    {
        parent::setUp();
        $this->hydrator = new Hydrator();
    }

    public function testClass()
    {
        /** @var Post $post */
        $post = $this->hydrator->hydrate(Post::class, [
            'public' => $public = 1,
            'protected' => $protected = 2,
            'private' => $private = 3,
        ]);

        $this->assertInstanceOf(Post::class, $post);

        $this->assertEquals($public, $post->getPublic());
        $this->assertEquals($protected, $post->getProtected());
        $this->assertEquals($private, $post->getPrivate());
    }

    public function testObject()
    {
        /** @var PostView $view */
        $view = $this->hydrator->hydrate($orig = new PostView(), [
            'public' => $public = 1,
            'protected' => $protected = 2,
            'private' => $private = 3,
        ]);

        $this->assertEquals($orig, $view);

        $this->assertEquals($public, $view->getPublic());
        $this->assertEquals($protected, $view->getProtected());
        $this->assertEquals($private, $view->getPrivate());
    }

    public function testNotExist()
    {
        $this->expectException(\ReflectionException::class);
        $this->expectExceptionMessage('Property other does not exist');

        $this->hydrator->hydrate(Post::class, [
            'public' => 1,
            'other' => 2,
        ]);
    }
}