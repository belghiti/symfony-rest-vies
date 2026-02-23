<?php
namespace Belghiti\Vies\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('peasy_vies');
        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('base_uri')->defaultValue('https://ec.europa.eu/taxation_customs/vies/rest-api')->end()
                ->integerNode('cache_ttl')->defaultValue(3600)->end()
            ->end();
        return $treeBuilder;
    }
}
