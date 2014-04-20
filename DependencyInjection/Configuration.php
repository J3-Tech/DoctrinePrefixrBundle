<?php

namespace DoctrinePrefixr\Bundle\DoctrinePrefixrBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Dickriven Chellemboyee <jchellem@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('doctrine_prefixr');
        $rootNode->children()
                    ->arrayNode('prefixes')
                        ->useAttributeAsKey('name')
                        ->prototype('scalar')->isRequired()->end()
                    ->end()
                ->end()
            ;

        return $treeBuilder;
    }
}
