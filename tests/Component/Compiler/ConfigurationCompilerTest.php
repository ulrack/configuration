<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Tests\Component\Compiler;

use PHPUnit\Framework\TestCase;
use Ulrack\Codec\Common\DecoderInterface;
use Ulrack\Vfs\Common\FileSystemInterface;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Vfs\Common\FileSystemDriverInterface;
use Ulrack\Configuration\Common\LocatorInterface;
use Ulrack\Configuration\Common\RegistryInterface;
use Ulrack\Configuration\Component\Configuration\PackageLocator;
use Ulrack\Configuration\Component\Compiler\ConfigurationCompiler;

/**
 * @coversDefaultClass \Ulrack\Configuration\Component\Compiler\ConfigurationCompiler
 */
class ConfigurationCompilerTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::addLocator
     * @covers ::compile
     */
    public function testCompiler(): void
    {
        $driver = $this->createMock(FileSystemDriverInterface::class);
        $subject = new ConfigurationCompiler($driver);

        PackageLocator::registerLocation(__DIR__);

        $this->assertInstanceOf(ConfigurationCompiler::class, $subject);

        $locator = $this->createMock(LocatorInterface::class);

        $subject->addLocator($locator);

        $fileSystem = $this->createMock(FileSystemInterface::class);

        $driver->expects(static::once())
            ->method('connect')
            ->with(__DIR__)
            ->willReturn($fileSystem);

        $locator->expects(static::once())
            ->method('getLocation')
            ->willReturn('configuration/');

        $fileSystem->expects(static::once())
            ->method('list')
            ->with('configuration')
            ->willReturn(['/foo.json']);

        $fileSystem->expects(static::once())
            ->method('isReadable')
            ->with('configuration/foo.json')
            ->willReturn(true);

        $decoder = $this->createMock(DecoderInterface::class);

        $locator->expects(static::once())
            ->method('getDecoder')
            ->willReturn($decoder);

        $decoder->expects(static::once())
            ->method('decode')
            ->with('{"foo": "bar"}')
            ->willReturn(['foo' => 'bar']);

        $fileSystem->expects(static::once())
            ->method('get')
            ->with('configuration/foo.json')
            ->willReturn('{"foo": "bar"}');

        $validator = $this->createMock(ValidatorInterface::class);

        $validator->expects(static::once())
            ->method('__invoke')
            ->with(['foo' => 'bar'])
            ->willReturn(true);

        $locator->expects(static::once())
            ->method('getValidator')
            ->willReturn($validator);

        $locator->expects(static::once())
            ->method('getKey')
            ->willReturn('foo');

        $result = $subject->compile();

        $this->assertInstanceOf(RegistryInterface::class, $result);

        $this->assertEquals(
            ['foo' => [['foo' => 'bar']]],
            $result->toArray()
        );
    }
}
