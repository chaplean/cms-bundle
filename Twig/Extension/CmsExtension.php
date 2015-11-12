<?php

namespace Chaplean\Bundle\CmsBundle\Twig\Extension;

/**
 * CmsExtension.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     2.0.0
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
            'cms_front_layout' => $this->getParameters('front_layout'),
        );
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getParameters($key)
    {
        return $this->parametersCms[$key];
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