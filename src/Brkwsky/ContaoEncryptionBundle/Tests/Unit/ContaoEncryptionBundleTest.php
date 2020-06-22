<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2020, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://brkwsky.de/>
 * @author        Christoph Werner <https://brkwsky.de/>
 */

namespace Brkwsky\ContaoEncryptionBundle\Tests\Unit;

use Brkwsky\ContaoEncryptionBundle\ContaoEncryptionBundle;
use PHPUnit\Framework\TestCase;

class ContaoEncryptionBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new ContaoEncryptionBundle();
        $this->assertInstanceOf('Brkwsky\ContaoEncryptionBundle\ContaoEncryptionBundle', $bundle);
    }
}
