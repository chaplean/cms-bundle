<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * MediaController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class MediaController extends Controller
{
    /**
     * @param string $path
     *
     * @return Response
     */
    public function downloadAction($path)
    {
        $fs = new Filesystem();
        $path = $this->getParameter('kernel.root_dir') . '/../web/' . $path;

        if (!$fs->exists($path)) {
            throw new NotFoundHttpException;
        }

        $fileName = explode($path, '/');
        return new Response(file_get_contents($path), 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="' . array_pop($fileName) . '"'
        ));
    }
}
