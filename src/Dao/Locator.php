<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Dao;

use Ulrack\Codec\Common\DecoderInterface;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Configuration\Common\LocatorInterface;
use Ulrack\Validator\Component\Logical\AlwaysValidator;

class Locator implements LocatorInterface
{
    /**
     * Contains the key used in the registry to register the configuration.
     *
     * @var string
     */
    private $key;

    /**
     * Contains the location which the compiler will seek to find files.
     *
     * @var string
     */
    private $location;

    /**
     * Contains the decoder which can decode the file.
     *
     * @var DecoderInterface
     */
    private $decoder;

    /**
     * Contains the validator which is used to validate the configuration.
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $location
     * @param DecoderInterface $decoder
     * @param ValidatorInterface $validator
     */
    public function __construct(
        string $key,
        string $location,
        DecoderInterface $decoder,
        ValidatorInterface $validator = null
    ) {
        $this->key = $key;
        $this->location = $location;
        $this->decoder = $decoder;
        $this->validator = $validator ?? new AlwaysValidator(true);
    }

    /**
     * Retrieves the decoder for the configuration.
     *
     * @return string
     */
    public function getDecoder(): DecoderInterface
    {
        return $this->decoder;
    }

    /**
     * Retrieves the validator which validates the integrity for configuration.
     *
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * Retrieves the location in which configuration needs to be fetched.
     *
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Retrieves the key for configuration.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
