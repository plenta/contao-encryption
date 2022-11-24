<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2022, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://plenta.io/>
 * @author        Christoph Werner <https://plenta.io/>
 */

namespace Plenta\ContaoEncryptionBundle\Classes;

use phpseclib3\Crypt\Blowfish;

/**
 * Class Encryption.
 */
class Encryption
{
    private ?string $encryptionKey;

    private string $iv = "\0\0\0\0\0\0\0\0";

    /**
     * Encryption constructor.
     */
    public function __construct(string $secret, bool $truncateKey)
    {
        $this->encryptionKey = $secret;
        if ($truncateKey) {
            $this->encryptionKey = substr($this->encryptionKey, 0, 56);
        }
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function encrypt($value)
    {
        if ('' === $value) {
            return '';
        }

        $cipher = new Blowfish('cbc');
        $cipher->setKey($this->encryptionKey);
        $cipher->setIV($this->iv);
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
        if ('' === $value) {
            return '';
        }

        $cipher = new Blowfish('cbc');
        $cipher->setKey($this->encryptionKey);
        $cipher->setIV($this->iv);
        $value = base64_decode($value, true);

        return $cipher->decrypt($value);
    }

    public function encryptUrlSafe($value): string
    {
        if ('' === $value) {
            return '';
        }

        $cipher = new Blowfish('cbc');
        $cipher->setKey($this->encryptionKey);
        $cipher->setIV($this->iv);
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
        if ('' === $value) {
            return '';
        }

        $cipher = new Blowfish('cbc');
        $cipher->setKey($this->encryptionKey);
        $cipher->setIV($this->iv);
        $value = base64_decode(strtr($value, '-_', '+/').str_repeat('=', 3 - (3 + \strlen($value)) % 4), true);

        return $cipher->decrypt($value);
    }
}
