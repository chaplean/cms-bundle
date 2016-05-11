<?php

namespace Chaplean\Bundle\CmsBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ConfigListener.
 *
 * @package   Chaplean\Bundle\CmsBundle\Listener
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class ConfigListener
{
    /**
     * @var array $configMedia
     */
    private $configCms;

    /**
     * @var array
     */
    private $controllerToFeature = array(
        'Chaplean\Bundle\CmsBundle\Controller\Rest\MediaController' => 'media',
        'Chaplean\Bundle\CmsBundle\Controller\Rest\BlockController' => 'block',
        'Chaplean\Bundle\CmsBundle\Controller\Rest\PostController'  => 'post',
        'Chaplean\Bundle\CmsBundle\Controller\PostController'       => 'post',
        'Chaplean\Bundle\CmsBundle\Controller\Rest\PageController'  => 'page',
        'Chaplean\Bundle\CmsBundle\Controller\PageController'       => 'page',
    );

    /**
     * ConfigListener constructor.
     *
     * @param array $configCms
     */
    public function __construct(array $configCms)
    {
        $this->configCms = $configCms;
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        /** @var array $controller */
        $controller = $event->getController();
        $request = $event->getRequest();

        if (is_array($this->configCms)) {
            $classController = get_class(array_shift($controller));
            $action = $request->attributes->get('_route');

            if (isset($this->controllerToFeature[$classController])) {
                $featureName = $this->controllerToFeature[$classController];

                if (isset($this->configCms['modules'][$featureName])) {
                    $featureValue = $this->configCms['modules'][$featureName];

                    if (!is_array($featureValue) && !$featureValue) {
                        throw new NotFoundHttpException;
                    }
                } else {
                    throw new NotFoundHttpException;
                }
            }
        }
    }
}
