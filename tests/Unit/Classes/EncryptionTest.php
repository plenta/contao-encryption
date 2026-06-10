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
use PHPUnit\Framework\Attributes\DataProvider;
use Plenta\ContaoEncryptionBundle\Classes\Encryption;

final class EncryptionTest extends ContaoTestCase
{
    private Encryption $objEncryption;

    private Encryption $objEncryptionTruncated;

    private string $encryptedValueTruncated = 'WlN8cEIMF6cQ3h6w1m59K3EBG+IIsf+H';

    private string $encryptedValue = 'VcCJVLZvmDaSsrrA/GnRwraF7rJ2YbE2';

    private string $decryptedValue = 'Max Mustermann 51';

    private int $decryptedInt = 97;

    private string $encryptedInt = 'FtZSNbAxJ7E=';

    private string $encryptedIntTruncated = 'WxLQ3B9fdHk=';

    protected function setUp(): void
    {
        $this->objEncryption = new Encryption('a08cbe3e62053d9141c5bef71096de4fd71722f8e294bdb1fb428dd81f1d3657', false);
        $this->objEncryptionTruncated = new Encryption('a08cbe3e62053d9141c5bef71096de4fd71722f8e294bdb1fb428dd81f1d3657', true);

        parent::setUp();
    }

    public static function invalidTypeProvider(): \Iterator
    {
        yield 'true' => [true];
        yield 'false' => [false];
        yield 'null' => [null];
        yield 'array' => [[]];
        yield 'object' => [(object) ['value' => 1]];
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

    public function testEncryptInt(): void
    {
        $this->assertSame($this->encryptedInt, $this->objEncryption->encrypt($this->decryptedInt));
        $this->assertSame($this->encryptedIntTruncated, $this->objEncryptionTruncated->encrypt($this->decryptedInt));
    }

    public function testDecryptInt(): void
    {
        $this->assertSame((string) $this->decryptedInt, $this->objEncryption->decrypt($this->encryptedInt));
        $this->assertSame((string) $this->decryptedInt, $this->objEncryptionTruncated->decrypt($this->encryptedIntTruncated));
    }

    public function testEncryptionUrlSafeCycleInt(): void
    {
        $encrypted = $this->objEncryption->encryptUrlSafe($this->decryptedInt);
        $decrypted = $this->objEncryption->decryptUrlSafe($encrypted);

        $this->assertSame($decrypted, (string) $this->decryptedInt);

        $encryptedTruncated = $this->objEncryptionTruncated->encryptUrlSafe($this->decryptedInt);
        $decryptedTruncated = $this->objEncryptionTruncated->decryptUrlSafe($encryptedTruncated);

        $this->assertSame($decryptedTruncated, (string) $this->decryptedInt);
    }

    public function testEmptyString(): void
    {
        $encrypted = $this->objEncryption->encrypt('');
        $this->assertSame('', $encrypted);

        $decrypted = $this->objEncryption->decrypt($encrypted);
        $this->assertSame('', $decrypted);

        $encrypted = $this->objEncryptionTruncated->encrypt('');
        $this->assertSame('', $encrypted);

        $decrypted = $this->objEncryptionTruncated->decrypt($encrypted);
        $this->assertSame('', $decrypted);

        $encrypted = $this->objEncryption->encryptUrlSafe('');
        $this->assertSame('', $encrypted);

        $decrypted = $this->objEncryptionTruncated->decryptUrlSafe($encrypted);
        $this->assertSame('', $decrypted);

        $encrypted = $this->objEncryptionTruncated->encryptUrlSafe('');
        $this->assertSame('', $encrypted);

        $decrypted = $this->objEncryptionTruncated->decryptUrlSafe($encrypted);
        $this->assertSame('', $decrypted);
    }

    #[DataProvider('invalidTypeProvider')]
    public function testEncryptThrowsTypeErrorForInvalidTypes(mixed $input): void
    {
        $this->expectException(\TypeError::class);
        $this->objEncryption->encrypt($input);
    }

    #[DataProvider('invalidTypeProvider')]
    public function testEncryptUrlSafeThrowsTypeErrorForInvalidTypes(mixed $input): void
    {
        $this->expectException(\TypeError::class);
        $this->objEncryption->encryptUrlSafe($input);
    }

    #[DataProvider('invalidTypeProvider')]
    public function testDecryptThrowsTypeErrorForInvalidTypes(mixed $input): void
    {
        $this->expectException(\TypeError::class);
        $this->objEncryption->decrypt($input);
    }

    #[DataProvider('invalidTypeProvider')]
    public function testDecryptUrlSafeThrowsTypeErrorForInvalidTypes(mixed $input): void
    {
        $this->expectException(\TypeError::class);
        $this->objEncryption->decryptUrlSafe($input);
    }

    public function testEncryptionIsDeterministicWithSameInput(): void
    {
        $value = 'test';

        $a = $this->objEncryption->encrypt($value);
        $b = $this->objEncryption->encrypt($value);

        $this->assertSame($a, $b);
    }
}
