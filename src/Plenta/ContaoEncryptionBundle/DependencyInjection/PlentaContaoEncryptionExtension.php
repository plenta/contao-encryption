<?php

declare(strict_types=1);

/**
 * Encryption extension for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2022, Christian Barkowsky & Christoph Werner
 * @author        Christian Barkowsky <https://plenta.io/>
 * @author        Christoph Werner <https://plenta.io/>
 */

namespace Plenta\ContaoEncryptionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PlentaContaoEncryptionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('plenta_contao_encryption.encryption_key', $config['encryption_key']);
        $container->setParameter('plenta_contao_encryption.truncate_encryption_key', $config['truncate_encryption_key']);
    }
}
