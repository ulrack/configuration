<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\Configuration\Common;

use Ulrack\Codec\Common\DecoderInterface;
use Ulrack\Validator\Common\ValidatorInterface;

interface LocatorInterface
{
    /**
     * Retrieves the decoder for the configuration.
     *
     * @return string
     */
    public function getDecoder(): DecoderInterface;

    /**
     * Retrieves the validator which validates the integrity for configuration.
     *
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface;

    /**
     * Retrieves the location in which configuration needs to be fetched.
     *
     * @return string
     */
    public function getLocation(): string;

    /**
     * Retrieves the key for configuration.
     *
     * @return string
     */
    public function getKey(): string;
}
