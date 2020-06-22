<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2020, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://brkwsky.de/>
 * @author        Christoph Werner <https://brkwsky.de/>
 */

namespace Brkwsky\ContaoEncryptionBundle\Tests\Unit\DependencyInjection;

use Brkwsky\ContaoEncryptionBundle\Classes\Encryption;
use Brkwsky\ContaoEncryptionBundle\DependencyInjection\ContaoEncryptionExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ContaoEncryptionExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new ContainerBuilder(new ParameterBag(['kernel.debug' => false]));
        $extension = new ContaoEncryptionExtension();
        $extension->load([], $this->container);
    }

    public function testEncryption(): void
    {
        $this->assertTrue($this->container->has('brkwsky.encryption'));
        $definition = $this->container->getDefinition('brkwsky.encryption');
        $this->assertSame(Encryption::class, $definition->getClass());
        $this->assertTrue($definition->isPublic());
    }
}
