<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2022, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://brkwsky.de/>
 * @author        Christoph Werner <https://brkwsky.de/>
 */

namespace Brkwsky\ContaoEncryptionBundle\Tests\Unit;

use Brkwsky\ContaoEncryptionBundle\PlentaContaoEncryptionBundle;
use PHPUnit\Framework\TestCase;

class PlentaContaoEncryptionBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new PlentaContaoEncryptionBundle();
        $this->assertInstanceOf('Brkwsky\ContaoEncryptionBundle\PlentaContaoEncryptionBundle', $bundle);
    }
}
