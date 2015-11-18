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

    private $controllerToFeature = array(
        'Chaplean\Bundle\CmsBundle\Controller\Rest\MediaController' => 'media'
    );

    public function __construct(array $configCms)
    {
        $this->configCms = $configCms;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (is_array($this->configCms)) {
            $controllerName = get_class($controller[0]);

            if (isset($this->controllerToFeature[$controllerName])) {
                $featureName = $this->controllerToFeature[$controllerName];

                if (isset($this->configCms[$featureName])) {
                    $featureValue = !$this->configCms[$featureName];

                    if(!is_array($featureValue) || !$featureValue) {
                        throw new NotFoundHttpException;
                    }
                }
            }
        }
    }
}
