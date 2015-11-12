<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Utility;

use Chaplean\Bundle\CmsBundle\Utility\Tools;
use Chaplean\Bundle\UnitBundle\Test\LogicalTest;

/**
 * Class Tools.
 *
 * @package   Chaplean\Bundle\CmsBundle\Utility
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class ToolsTest extends LogicalTest
{
    /**
     * @return void
     */
    public function testSlugify()
    {
        $this->assertEquals('sensio', Tools::slugify('Sensio'));
        $this->assertEquals('sensio-labs', Tools::slugify('sensio labs'));
        $this->assertEquals('sensio-labs', Tools::slugify('sensio   labs'));
        $this->assertEquals('paris-france', Tools::slugify('paris,france'));
        $this->assertEquals('sensio', Tools::slugify('     sensio'));
        $this->assertEquals('sensio', Tools::slugify('sensio   '));
        $this->assertEquals('n-a', Tools::slugify('     '));
    }

    /**
     * @return void
     */
    public function testRemoveAccent()
    {
        $string = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïñòóôõöøùúûüýÿĀāĂăĄąĆćĈĉĊċ' .
            'ČčĎďĐđĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħĨĩĪīĬĭĮįİıĲĳĴĵĶķĹĺĻļĽľĿŀŁłŃńŅņŇňŉŌōŎŏŐőŒœŔŕ' .
            'ŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧŨũŪūŬŭŮůŰűŲųŴŵŶŷŸŹźŻżŽžſƒƠơƯưǍǎǏǐǑǒǓǔǕǖǗǘǙǚǛǜǺǻǼǽǾǿ';

        $stringWithoutAccent = 'AAAAAAAECEEEEIIIIDNOOOOOOUUUUYsaaaaaaaeceeeeiiiinoooooouuuuyyAaAaAaCcCcCc' .
            'CcDdDdEeEeEeEeEeGgGgGgGgHhHhIiIiIiIiIiIJijJjKkLlLlLlLlLlNnNnNnnOoOoOoOEoeR' .
            'rRrRrSsSsSsSsTtTtTtUuUuUuUuUuUuWwYyYZzZzZzsfOoUuAaIiOoUuUuUuUuUuAaAEaeOo';

        $this->assertEquals($stringWithoutAccent, Tools::removeAccent($string));
    }
}
