<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Tests\Component\Configuration;

use PHPUnit\Framework\TestCase;
use Ulrack\Configuration\Component\Configuration\PackageLocator;

/**
 * @coversDefaultClass \Ulrack\Configuration\Component\Configuration\PackageLocator
 */
class PackageLocatorTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::registerLocation
     * @covers ::getLocations
     */
    public function testPackageLocator(): void
    {
        PackageLocator::registerLocation('foo');
        PackageLocator::registerLocation('bar');
        $this->assertContains('foo', PackageLocator::getLocations());
        $this->assertContains('bar', PackageLocator::getLocations());
    }
}
