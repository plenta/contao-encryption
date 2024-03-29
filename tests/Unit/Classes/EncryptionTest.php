<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2022, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://plenta.io/>
 * @author        Christoph Werner <https://plenta.io/>
 */

namespace Plenta\ContaoEncryptionBundle\Tests\Unit\Classes;

use Contao\TestCase\ContaoTestCase;
use Plenta\ContaoEncryptionBundle\Classes\Encryption;

class EncryptionTest extends ContaoTestCase
{
    private ?Encryption $objEncryption;
    private ?Encryption $objEncryptionTruncated;
    private string $encryptedValueTruncated = 'WlN8cEIMF6cQ3h6w1m59K3EBG+IIsf+H';
    private string $encryptedValue = 'VcCJVLZvmDaSsrrA/GnRwraF7rJ2YbE2';
    private string $decryptedValue = 'Max Mustermann 51';

    protected function setUp(): void
    {
        $this->objEncryption = new Encryption('a08cbe3e62053d9141c5bef71096de4fd71722f8e294bdb1fb428dd81f1d3657', false);
        $this->objEncryptionTruncated = new Encryption('a08cbe3e62053d9141c5bef71096de4fd71722f8e294bdb1fb428dd81f1d3657', true);

        parent::setUp();
    }

    public function testEncrypt(): void
    {
        $this->assertSame($this->encryptedValue, $this->objEncryption->encrypt($this->decryptedValue));
        $this->assertSame($this->encryptedValueTruncated, $this->objEncryptionTruncated->encrypt($this->decryptedValue));
    }

    public function testDecrypt(): void
    {
        $this->assertSame($this->decryptedValue, $this->objEncryption->decrypt($this->encryptedValue));
        $this->assertSame($this->decryptedValue, $this->objEncryptionTruncated->decrypt($this->encryptedValueTruncated));
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

        $encryptedTruncated = $this->objEncryptionTruncated->encryptUrlSafe($this->decryptedValue);
        $decryptedTruncated = $this->objEncryptionTruncated->decryptUrlSafe($encryptedTruncated);

        $this->assertSame($decryptedTruncated, $this->decryptedValue);
    }
}
