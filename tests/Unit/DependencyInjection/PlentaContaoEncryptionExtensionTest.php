<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2022, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://plenta.io/>
 * @author        Christoph Werner <https://plenta.io/>
 */

namespace Plenta\ContaoEncryptionBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Plenta\ContaoEncryptionBundle\Classes\Encryption;
use Plenta\ContaoEncryptionBundle\DependencyInjection\PlentaContaoEncryptionExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class PlentaContaoEncryptionExtensionTest extends TestCase
{
    private ContainerBuilder $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new ContainerBuilder(new ParameterBag(['kernel.debug' => false]));
        $extension = new PlentaContaoEncryptionExtension();
        $extension->load([], $this->container);
    }

    public function testEncryption(): void
    {
        $this->assertTrue($this->container->has('Plenta\ContaoEncryptionBundle\Classes\Encryption'));
        $definition = $this->container->getAlias('Plenta\ContaoEncryptionBundle\Classes\Encryption');
        $this->assertTrue($definition->isPublic());

        $this->assertTrue($this->container->has('brkwsky.encryption'));
        $definition = $this->container->getAlias('brkwsky.encryption');
        $this->assertTrue($definition->isPublic());

        $this->assertTrue($this->container->has('plenta.encryption'));
        $definition = $this->container->getDefinition('plenta.encryption');
        $this->assertSame(Encryption::class, $definition->getClass());
        $this->assertTrue($definition->isPublic());
    }
}
