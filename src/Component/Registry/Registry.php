<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Component\Registry;

use Ulrack\Configuration\Common\RegistryInterface;
use Ulrack\Validator\Component\Chain\AndValidator;
use Ulrack\Validator\Component\Type\ArrayValidator;
use Ulrack\Validator\Component\Iterable\ItemsValidator;

class Registry implements RegistryInterface
{
    /**
     * Contains all registered values in the registry.
     *
     * @var array
     */
    private $registry = [];

    /**
     * Validator for importing configuration.
     *
     * @var ValidatorInterface
     */
    private $importValidator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->importValidator = new AndValidator(
            new ArrayValidator(),
            new ItemsValidator(null, new ArrayValidator())
        );
    }

    /**
     * Register a value in the registry.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function register(string $key, $value): void
    {
        $this->registry[$key][] = $value;
    }

    /**
     * Converts the registry to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->registry;
    }

    /**
     * Imports a registry from an array into the registry.
     *
     * @param array $registry
     *
     * @return void
     */
    public function import(array $registry): void
    {
        if (($this->importValidator)($registry)) {
            $this->registry = array_merge_recursive(
                $this->registry,
                $registry
            );
        }
    }

    /**
     * Retrieves all registered data associated with a key.
     *
     * @param string $key
     *
     * @return array
     */
    public function get(string $key): array
    {
        return $this->registry[$key] ?? [];
    }
}
