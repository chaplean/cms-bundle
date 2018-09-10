<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * DefaultController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.1.0
 */
class DefaultController extends Controller
{
    /**
     * @Route("/administration", name="cms_back_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $landingRoute = $this->getParameter('chaplean_cms.template.back_landing_route');

        return new RedirectResponse($this->generateUrl($landingRoute));
    }

    /**
     * @Route("/administration/home", name="cms_back_home")
     *
     * @return Response
     */
    public function homeAction()
    {
        $view = $this->getParameter('chaplean_cms.template.back_index_view');

        return $this->render($view);
    }
}
