<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     *
     * @return Response
     */
    public function downloadAction(Request $request)
    {
        $path = $request->get('path');
        $name = $request->get('fileName');
        $fs = new Filesystem();
        $path = $this->getParameter('kernel.root_dir') . '/../web/' . $path;

        if (!$fs->exists($path)) {
            throw new NotFoundHttpException;
        }
        if ($name) {
            $fileName = $name;
        } else {
            $fileName = explode($path, '/');
            $fileName = array_pop($fileName);
        }

        return new Response(file_get_contents($path), 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ));
    }
}
