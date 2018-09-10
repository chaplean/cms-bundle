<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Back\Controller;

use Chaplean\Bundle\UnitBundle\Test\FunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PageControllerTest.
 *
 * @package   Chaplean\Bundle\CmsBundle\Tests
 * @author    Tom - Chaplean <tom@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     7.0.0
 */
class PageControllerTest extends FunctionalTestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Controller\Back\PageController::editAction()
     *
     * @return void
     */
    public function testEditActionWithInvalidPageId()
    {
        $client = static::createClient();

        $client->request('GET', '/administration/page/bad');

        $this->assertTrue(
            $client->getResponse()
                ->isNotFound()
        );
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Controller\Back\PageController::editAction()
     *
     * @return void
     */
    public function testNewActionWorking()
    {
        $client = static::createClient();

        $client->request('GET', '/administration/page');

        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()
                ->getStatusCode()
        );
    }
}
