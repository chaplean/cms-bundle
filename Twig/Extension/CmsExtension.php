<?php

namespace Chaplean\Bundle\CmsBundle\Twig\Extension;

use Chaplean\Bundle\CmsBundle\DependencyInjection\Configuration;

/**
 * CmsExtension.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class CmsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var array
     */
    private $parametersCms;

    /**
     * CmsExtension constructor.
     *
     * @param array $parametersCms
     */
    public function __construct(array $parametersCms)
    {
        $this->parametersCms = $parametersCms;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return [
            'access_debug'      => $this->getParameters('access_debug'),
            'cms_back_layout'   => $this->getParameters('template', 'back_layout'),
            'cms_front_layout'  => $this->getParameters('template', 'front_layout'),
            'cms_front_route'   => $this->getParameters('template', 'front_route'),
            'cms_logo_path'     => $this->getParameters('template', 'logo_path'),
            'block_is_activate' => $this->moduleIsActived('block'),
            'post_is_activate'  => $this->moduleIsActived('post'),
            'page_is_activate'  => $this->moduleIsActived('page'),
            'media_is_activate' => $this->moduleIsActived('media'),
            'cms_action'        => $this->getActionModule(),
        ];
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getParameters($key)
    {
        $args = func_get_args();

        $key = array_shift($args);
        if (count($args) > 0) {
            $value = $this->parametersCms[$key];
            foreach ($args as $arg) {
                $value = $value[$arg];
            }
            return $value;
        } else {
            return is_array($this->parametersCms[$key]) ? $this->parametersCms[$key] : $this->parametersCms[$key];
        }
    }

    /**
     * @return array
     */
    public function getActionModule()
    {
        $actionsByModules = [
            'block' => [],
            'page'  => [],
            'post'  => [],
        ];

        if (is_bool($this->parametersCms['modules']['block']) && $this->parametersCms['modules']['block']) {
            $actionsByModules['block'] = Configuration::availableAction('block');
        } elseif (is_array($this->parametersCms['modules']['block'])) {
            $actionsByModules['block'] = $this->parametersCms['modules']['block'];
        }

        if (is_bool($this->parametersCms['modules']['page']) && $this->parametersCms['modules']['page']) {
            $actionsByModules['page'] = Configuration::availableAction('page');
        } elseif (is_array($this->parametersCms['modules']['page'])) {
            $actionsByModules['page'] = $this->parametersCms['modules']['page'];
        }

        if (is_bool($this->parametersCms['modules']['post']['action']) && (bool) $this->parametersCms['modules']['post']['action']) {
            $actionsByModules['post'] = Configuration::availableAction('post');
        } elseif (is_array($this->parametersCms['modules']['post']['action'])) {
            $actionsByModules['post'] = $this->parametersCms['modules']['post']['action'];
        }

        return $actionsByModules;
    }

    /**
     * @param string $module
     *
     * @return mixed
     */
    public function moduleIsActived($module)
    {
        if ($module == 'post') {
            return (is_bool($this->parametersCms['modules'][$module]['action']) && $this->parametersCms['modules'][$module]['action'])
            || is_array($this->parametersCms['modules'][$module]['action']);
        } else {
            return (is_bool($this->parametersCms['modules'][$module]) && $this->parametersCms['modules'][$module])
            || is_array($this->parametersCms['modules'][$module]);
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'chaplean_cms_twig_extension';
    }
}
