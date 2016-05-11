<?php

namespace Chaplean\Bundle\CmsBundle\DependencyInjection;

use Chaplean\Bundle\CmsBundle\Utility\PostUtility;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Config\Definition\Builder\VariableNodeDefinition;

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
                ->booleanNode('access_debug')->defaultFalse()->end()
                ->arrayNode('modules')
                ->children()
                    ->append($this->addSimpleModule('block'))
                    ->append($this->addSimpleModule('page'))
                    ->append($this->addPostModule())
                    ->append($this->addMediaModule())
                ->end()
                ->end()
                ->arrayNode('template')
                    ->children()
                        ->scalarNode('front_layout')->isRequired()->end()
                        ->scalarNode('front_route')->defaultValue('app_front')->end()
                        ->scalarNode('logo_path')->defaultValue('')->end()
                        ->scalarNode('page_index')->defaultValue('ChapleanCmsBundle:Front/Page:index.html.twig')->end()
                        ->scalarNode('page_view')->defaultValue('ChapleanCmsBundle:Front/Page:view.html.twig')->end()
                        ->scalarNode('post_index')->defaultValue('ChapleanCmsBundle:Front/Post:index.html.twig')->end()
                        ->scalarNode('post_view')->defaultValue('ChapleanCmsBundle:Front/Post:view.html.twig')->end()
                    ->end()
                ->end()
            ->end();
        
        return $treeBuilder;
    }

    /**
     * Build a simple module containing only action
     *
     * @param string $type
     *
     * @return NodeDefinition
     */
    public function addSimpleModule($type)
    {
        $node = new NodeBuilder();

        return $node
            ->variableNode($type)
                ->isRequired()
                ->validate()
                ->always(function($v) use ($type) {
                    if (is_bool($v)) {
                        return Configuration::availableAction($type);
                    } elseif (is_array($v)) {
                        foreach ($v as $item) {
                            if (!in_array($item, Configuration::availableAction($type))) {
                                throw new InvalidTypeException(sprintf('Invalid configuration for %s, \'%s\' is not an action available', $type, $item));
                            }
                        }
                        return $v;
                    } else {
                        return false;
                    }
                })
            ->end();
    }

    /**
     * Build node for special option 'Post'
     * with manage of multiple type of Post (news, zoom...)
     * and actions ('add', 'duplicate')
     *
     * @return mixed
     */
    public function addPostModule()
    {
        $category = new VariableNodeDefinition('category');
        $category
            ->isRequired()
            ->validate()
            ->always(function ($v) {
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
            })
            ->end()
        ->end();
        $action = new VariableNodeDefinition('action');
        $action
            ->isRequired()
            ->validate()
            ->always(function($v) {
                if (is_bool($v)) {
                    return Configuration::availableAction('post');
                } elseif (is_array($v)) {
                    foreach ($v as $item) {
                        if (!in_array($item, Configuration::availableAction('post'))) {
                            throw new InvalidTypeException(sprintf('Invalid configuration for post, \'%s\' is not an action available', $item));
                        }
                    }
                    return $v;
                } else {
                    return false;
                }
            })
            ->end()
        ->end();

        $node = new ArrayNodeDefinition('post');
        return $node
            ->append($category)
            ->append($action);
    }

    /**
     * Build a media node
     *
     * @return NodeDefinition
     */
    public function addMediaModule()
    {
        $blockNode = new VariableNodeDefinition('media');
        return $blockNode
            ->isRequired()
            ->validate()
            ->always(function($v) {
                if (is_bool($v) || is_array($v)) {
                    return $v;
                } else {
                    return false;
                }
            })
            ->end();
    }

    /**
     * Action available for node modules
     *
     * @param string $type
     *
     * @return array
     */
    public static function availableAction($type)
    {
        $actions = array(
            'block' => array('add', 'remove'),
            'page'  => array('add', 'remove'),
            'post'  => array('add', 'duplicate', 'remove')
        );

        return $actions[$type];
    }
}
