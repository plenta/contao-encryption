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

use phpseclib\Crypt\Blowfish;

/**
 * Class Encryption.
 */
class Encryption
{
    private ?string $encryptionKey;

    /**
     * Encryption constructor.
     */
    public function __construct(string $secret)
    {
        $this->encryptionKey = $secret;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function encrypt($value)
    {
        $cipher = new Blowfish();
        $cipher->setKey($this->encryptionKey);
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

        $cipher = new Blowfish();
        $cipher->setKey($this->encryptionKey);
        $value = base64_decode($value, true);

        return $cipher->decrypt($value);
    }

    public function encryptUrlSafe($value): string
    {
        $cipher = new Blowfish();
        $cipher->setKey($this->encryptionKey);
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
        $cipher->setKey($this->encryptionKey);
        $value = base64_decode(strtr($value, '-_', '+/').str_repeat('=', 3 - (3 + \strlen($value)) % 4), true);

        return $cipher->decrypt($value);
    }
}
