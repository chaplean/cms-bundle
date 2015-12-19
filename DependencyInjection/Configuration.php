<?php

namespace Chaplean\Bundle\CmsBundle\DependencyInjection;

use Chaplean\Bundle\CmsBundle\Utility\PostUtility;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

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
            ->booleanNode('access_debug')->defaultValue('false')->end()
                ->arrayNode('template')
                    ->children()
                        ->scalarNode('front_layout')->isRequired()->end()
                        ->scalarNode('page_index')->defaultValue('ChapleanCmsBundle:Front/Page:index.html.twig')->end()
                        ->scalarNode('page_view')->defaultValue('ChapleanCmsBundle:Front/Page:view.html.twig')->end()
                        ->scalarNode('post_index')->defaultValue('ChapleanCmsBundle:Front/Post:index.html.twig')->end()
                        ->scalarNode('post_view')->defaultValue('ChapleanCmsBundle:Front/Post:view.html.twig')->end()
                    ->end()
                ->end()
                ->booleanNode('block')->isRequired()->end()
                ->booleanNode('page')->isRequired()->end()
                ->variableNode('media')
                    ->isRequired()
                    ->validate()
                        ->always(function($v) use ($rootNode) {
                            if (is_bool($v)) {
                                return $v;
                            } elseif (is_array($v)) {
                                foreach ($v as $item) {
                                    if (!is_string($item)) {
                                        throw new InvalidTypeException(sprintf('Invalid configuration for media, \'%s\' is not a string', $item));
                                    }
                                }
                                return $v;
                            } else {
                                throw new InvalidTypeException(sprintf('Invalid configuration for media, \'%s\' is not a boolean nor an array of strings', $v));
                            }
                        })->end()
                    ->end()
                ->variableNode('post')
                    ->isRequired()
                    ->validate()
                        ->always(function($v) use ($rootNode) {
                            if (is_bool($v)) {
                                return $v;
                            } elseif (is_array($v)) {
                                $availableType = array_values(PostUtility::getAvailableInstance());
                                foreach ($v as $item) {
                                    if (!in_array($item, $availableType)) {
                                        throw new InvalidTypeException(sprintf('Invalid configuration for post, \'%s\' is undefined type', $item));
                                    }
                                }

                                return $v;
                            } else {
                                throw new InvalidTypeException();
                            }
                        })->end()
                    ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
