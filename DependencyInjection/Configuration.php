<?php

namespace Kristofvc\ListBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kristofvc_list');

        $rootNode
            ->children()
                ->scalarNode('driver')
                    ->defaultValue('orm')
                ->end()
                ->scalarNode('items_per_page')
                    ->defaultValue(15)
                ->end()
                ->scalarNode('page_parameter_name')
                    ->defaultValue('page')
                ->end()
                ->scalarNode('list_template')
                    ->defaultValue('KristofvcListBundle:ListTemplates:default_list.html.twig')
                ->end()
                ->scalarNode('column_empty_value')
                    ->defaultValue(' ')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
