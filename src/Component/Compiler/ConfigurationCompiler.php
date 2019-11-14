<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Component\Compiler;

use Ulrack\Vfs\Common\FileSystemDriverInterface;
use Ulrack\Configuration\Common\LocatorInterface;
use Ulrack\Configuration\Common\CompilerInterface;
use Ulrack\Configuration\Common\RegistryInterface;
use Ulrack\Configuration\Component\Registry\Registry;
use Ulrack\Configuration\Component\Configuration\PackageLocator;

class ConfigurationCompiler implements CompilerInterface
{
    /**
     * Contains the locators.
     *
     * @var LocatorInterface[]
     */
    private $locators = [];

    /**
     * Contains the driver for traversing over the files.
     *
     * @var FileSystemDriverInterface
     */
    private $driver;

    /**
     * Constructor
     *
     * @param FileSystemDriverInterface $driver
     */
    public function __construct(FileSystemDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Adds a locator to the compiler.
     *
     * @param LocatorInterface $locator
     *
     * @return void
     */
    public function addLocator(LocatorInterface $locator): void
    {
        $this->locators[] = $locator;
    }

    /**
     * Compiles configuration into an array of data.
     *
     * @return RegistryInterface
     */
    public function compile(): RegistryInterface
    {
        $packages = PackageLocator::getLocations();
        $registry = new Registry();

        foreach ($packages as $package) {
            $fileSystem = $this->driver->connect($package);

            foreach ($this->locators as $locator) {
                $directory = rtrim($locator->getLocation(), '/');

                foreach ($fileSystem->list($directory) as $file) {
                    $file = sprintf('%s/%s', $directory, ltrim($file, '/'));

                    if ($fileSystem->isReadable($file)) {
                        $configuration = $locator->getDecoder()
                            ->decode(
                                $fileSystem->get($file)
                            );

                        if ($locator->getValidator()
                                ->__invoke($configuration)) {
                            $registry->register(
                                $locator->getKey(),
                                $configuration
                            );
                        }
                    }
                }
            }

            $this->driver->disconnect($fileSystem);
        }

        return $registry;
    }
}
