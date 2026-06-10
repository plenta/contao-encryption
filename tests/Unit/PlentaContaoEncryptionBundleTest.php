<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2022, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://plenta.io/>
 * @author        Christoph Werner <https://plenta.io/>
 */

namespace Plenta\ContaoEncryptionBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Plenta\ContaoEncryptionBundle\PlentaContaoEncryptionBundle;

final class PlentaContaoEncryptionBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new PlentaContaoEncryptionBundle();
        $this->assertSame(
            'PlentaContaoEncryptionBundle',
            (new \ReflectionClass($bundle))->getShortName(),
        );
    }
}
