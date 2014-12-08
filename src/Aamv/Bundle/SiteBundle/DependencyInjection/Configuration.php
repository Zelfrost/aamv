<?php

namespace Aamv\Bundle\SiteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('aamv_site');

        $rootNode
            ->children()
                ->arrayNode('news')
                    ->isRequired()
                    ->children()
                        ->scalarNode('result_per_page')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->defaultValue(10)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
