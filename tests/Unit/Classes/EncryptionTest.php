<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2020, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://brkwsky.de/>
 * @author        Christoph Werner <https://brkwsky.de/>
 */

namespace Brkwsky\ContaoEncryptionBundle\Tests\Unit\Classes;

use Brkwsky\ContaoEncryptionBundle\Classes\Encryption;
use Contao\TestCase\ContaoTestCase;

class EncryptionTest extends ContaoTestCase
{
    /**
     * @var Encryption|null
     */
    private $objEncryption;

    /**
     * @var string
     */
    private $encryptedValue = 'WlN8cEIMF6cQ3h6w1m59K3EBG+IIsf+H';

    /**
     * @var string
     */
    private $decryptedValue = 'Max Mustermann 51';

    public function setUp(): void
    {
        $this->objEncryption = new Encryption('a08cbe3e62053d9141c5bef71096de4fd71722f8e294bdb1fb428dd81f1d3657');

        parent::setUp();
    }

    public function testEncrypt(): void
    {
        $this->assertSame($this->encryptedValue, $this->objEncryption->encrypt($this->decryptedValue));
    }

    public function testDecrypt(): void
    {
        $this->assertSame($this->decryptedValue, $this->objEncryption->decrypt($this->encryptedValue));
    }

    public function testEncryptEmptyString(): void
    {
        $encrypted = $this->objEncryption->encrypt('');
        $decrypted = $this->objEncryption->decrypt($encrypted);
        $this->assertSame('', $decrypted);

        $this->assertSame('', $this->objEncryption->decrypt(''));
    }

    public function testEncryptionUrlSafeCycle(): void
    {
        $encrypted = $this->objEncryption->encryptUrlSafe($this->decryptedValue);
        $decrypted = $this->objEncryption->decryptUrlSafe($encrypted);

        $this->assertSame($decrypted, $this->decryptedValue);
    }
}
