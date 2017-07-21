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

class ExtractTest extends TestCase
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

    public function testFull()
    {
        $tag = new Tag(1, 2, 3);

        $row = $this->hydrator->extract($tag, ['public', 'protected', 'private']);

        $this->assertEquals([
            'public' => $tag->getPublic(),
            'protected' => $tag->getProtected(),
            'private' => $tag->getPrivate(),
        ], $row);
    }

    public function testPartial()
    {
        $tag = new Tag(1, 2, 3);
        $row = $this->hydrator->extract($tag, ['protected', 'private']);

        $this->assertEquals([
            'protected' => $tag->getProtected(),
            'private' => $tag->getPrivate(),
        ], $row);
    }

    public function testNotExist()
    {
        $this->expectException(\ReflectionException::class);
        $this->expectExceptionMessage('Property other does not exist');

        $tag = new Tag(1, 2, 3);
        $this->hydrator->extract($tag, ['public', 'other']);
    }
}