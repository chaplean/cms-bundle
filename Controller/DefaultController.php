<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * DefaultController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.1.0
 */
class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $landing_route = $this->getParameter('chaplean_cms.template.back_landing_route');
        return new RedirectResponse($this->generateUrl($landing_route));
    }

    /**
     * @return Response
     */
    public function homeAction()
    {
        return $this->render('ChapleanCmsBundle:Back:index.html.twig');
    }
}
