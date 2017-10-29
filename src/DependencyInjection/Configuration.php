<?php

namespace Davison\CsrfProtectedRoutingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('csrf_protected_routing')
            ->children()
                ->scalarNode('request_parameter')
                    ->defaultValue('_rt')
                ->end()
                ->scalarNode('token_id')
                    ->defaultValue('routing')
                ->end()
                ->arrayNode('routes')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}