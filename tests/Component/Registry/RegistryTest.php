<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Tests\Component\Registry;

use PHPUnit\Framework\TestCase;
use Ulrack\Configuration\Component\Registry\Registry;

/**
 * @coversDefaultClass \Ulrack\Configuration\Component\Registry\Registry
 */
class RegistryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::register
     * @covers ::toArray
     * @covers ::import
     * @covers ::get
     */
    public function testRegistry(): void
    {
        $subject = new Registry();

        $this->assertInstanceOf(Registry::class, $subject);

        $this->assertEquals([], $subject->toArray());
        $this->assertEquals([], $subject->get('foo'));

        $subject->register('foo', 'bar');
        $subject->register('foo', 'baz');

        $this->assertEquals(['foo' => ['bar', 'baz']], $subject->toArray());
        $this->assertEquals(['bar', 'baz'], $subject->get('foo'));

        $subject->import(['bar' => ['foo', 'bar'], 'foo' => ['qux']]);

        $this->assertEquals(
            ['foo' => ['bar', 'baz', 'qux'], 'bar' => ['foo', 'bar']],
            $subject->toArray()
        );
    }
}
