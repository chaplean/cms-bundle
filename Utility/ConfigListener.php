<?php

namespace Chaplean\Bundle\CmsBundle\Utility;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            $controllerName = get_class(array_shift($controller));

            if (isset($this->controllerToFeature[$controllerName])) {
                $featureName = $this->controllerToFeature[$controllerName];

                

                if (isset($this->configCms[$featureName])) {
                    $featureValue = $this->configCms[$featureName];

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
