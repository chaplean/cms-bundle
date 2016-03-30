<?php

namespace Chaplean\Bundle\CmsBundle\Twig\Extension;

/**
 * CmsExtension.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
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
        return array(
            'access_debug'      => $this->getParameters('access_debug'),
            'cms_front_layout'  => $this->getParameters('template', 'front_layout'),
            'cms_front_route'   => $this->getParameters('template', 'front_route'),
            'cms_logo_path'     => $this->getParameters('template', 'logo_path'),
            'block_is_activate' => $this->getParameters('block'),
            'post_is_activate'  => is_bool($this->getParameters('post')) ? $this->getParameters('post') : true,
            'page_is_activate'  => $this->getParameters('page'),
            'media_is_activate' => $this->getParameters('media'),
        );
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
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'chaplean_cms_twig_extension';
    }
}
