<?php

namespace Chaplean\Bundle\CmsBundle\DependencyInjection;

use JMS\DiExtraBundle\Exception\InvalidTypeException;
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
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('chaplean_cms');

        $rootNode
            ->children()
                ->scalarNode('front_layout')->isRequired()->end()
                ->variableNode('media')
                    ->isRequired()
                    ->validate()
                        ->always(function($v) use ($rootNode) {
                            if (is_bool($v)) {
                                return $v;
                            } else if (is_array($v)) {
                                return $v;
                            } else {
                                throw new InvalidTypeException();
                            }
                        })
                    ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
