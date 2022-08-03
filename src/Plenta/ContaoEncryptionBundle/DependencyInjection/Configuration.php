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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('plenta_contao_encryption');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('encryption_key')
                    ->cannotBeEmpty()
                    ->defaultValue('%kernel.secret%')
                ->end()
                ->scalarNode('truncate_encryption_key')
                    ->defaultTrue()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
