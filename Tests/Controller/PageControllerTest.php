<?php

namespace Chaplean\Bundle\CmsBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PageControllerTest.
 *
 * @package   Chaplean\Bundle\CmsBundle\Tests
 * @author    Tom - Chaplean <tom@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     7.0.0
 */
class PageControllerTest extends WebTestCase
{
    /**
     * @return void
     */
    public function testEditActionWithInvalidPageId()
    {
        $client = static::createClient();

        $client->request('GET', '/administration/page/bad');

        $this->assertTrue($client->getResponse()->isNotFound());
    }
    /**
     * @return void
     */
    public function testNewActionWorking()
    {
        $client = static::createClient();

        $client->request('GET', '/administration/page');

        $this->assertTrue($client->getResponse()->isOk());
    }
}
