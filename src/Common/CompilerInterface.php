<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Common;

interface CompilerInterface
{
    /**
     * Adds a locator to the compiler.
     *
     * @param LocatorInterface $locator
     *
     * @return void
     */
    public function addLocator(LocatorInterface $locator): void;

    /**
     * Compiles configuration into an array of data.
     *
     * @return RegistryInterface
     */
    public function compile(): RegistryInterface;
}
