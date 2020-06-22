<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2020, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://brkwsky.de/>
 * @author        Christoph Werner <https://brkwsky.de/>
 */

namespace Brkwsky\ContaoEncryptionBundle\Classes;

use phpseclib\Crypt\Blowfish;

/**
 * Class Encryption
 * @package Brkwsky\ContaoEncryptionBundle\Classes
 */
class Encryption
{
    /**
     * @var string|null
     */
    private $publicKey;

    /**
     * Encryption constructor.
     */
    public function __construct(string $secret)
    {
        $this->publicKey = $secret;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function encrypt($value)
    {
        $cipher = new Blowfish();
        $cipher->setKey($this->publicKey);
        $value = $cipher->encrypt($value);

        return base64_encode($value);
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function decrypt($value)
    {
        $cipher = new Blowfish();
        $cipher->setKey($this->publicKey);
        $value = base64_decode($value, true);

        return $cipher->decrypt($value);
    }

    /**
     * @param $value
     *
     * @return string|string[]
     */
    public function encryptUrlSafe($value)
    {
        $cipher = new Blowfish();
        $cipher->setKey($this->publicKey);
        $value = $cipher->encrypt($value);
        $valueBase64 = base64_encode($value);

        return rtrim(strtr($valueBase64, '+/', '-_'), '=');
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function decryptUrlSafe($value)
    {
        $cipher = new Blowfish();
        $cipher->setKey($this->publicKey);
        $value = base64_decode(strtr($value, '-_', '+/').str_repeat('=', 3 - (3 + \strlen($value)) % 4), true);

        return $cipher->decrypt($value);
    }
}
