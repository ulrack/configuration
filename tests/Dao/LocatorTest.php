<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Tests\Dao;

use PHPUnit\Framework\TestCase;
use Ulrack\Configuration\Dao\Locator;
use Ulrack\Codec\Common\DecoderInterface;
use Ulrack\Validator\Common\ValidatorInterface;

/**
 * @coversDefaultClass \Ulrack\Configuration\Dao\Locator
 */
class LocatorTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::getKey
     * @covers ::getLocation
     * @covers ::getDecoder
     * @covers ::getValidator
     */
    public function testLocator(): void
    {
        $subject = new Locator(
            'foo',
            'bar',
            $this->createMock(DecoderInterface::class)
        );

        $this->assertInstanceOf(Locator::class, $subject);

        $this->assertEquals(
            'foo',
            $subject->getKey()
        );

        $this->assertEquals(
            'bar',
            $subject->getLocation()
        );

        $this->assertInstanceOf(
            DecoderInterface::class,
            $subject->getDecoder()
        );

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->getValidator()
        );
    }
}
