<?php

namespace Chaplean\Bundle\CmsBundle\Features\Context;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
use Chaplean\Bundle\UnitBundle\Features\Context\ChapleanContext;

/**
 * Class FeatureContext.
 *
 * @package   Chaplean\Bundle\CmsBundle\Features\Context
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class FeatureContext extends ChapleanContext
{
    /**
     * Handle browser modal dialog
     *
     * source : https://gist.github.com/blazarecki/2888851
     *
     * @Then /^(?:|I )should see a confirm dialog$/
     *
     * @return void
     */
    public function assertBrowserModal()
    {
        $this->getSession()->getDriver()->getWebDriverSession()->accept_alert();
    }

    /**
     * Checks, that option from select with specified id|name|label|value is selected.
     *
     */

    /**
     * Checks, that option from select with specified id|name|label|value is selected.
     *
     * @param string $option The value to see if it is selected
     * @param array  $select The options elements
     *
     * @Then /^the "(?P<option>(?:[^"]|\\")*)" option from "(?P<select>(?:[^"]|\\")*)" (?:is|should be) selected/
     * @Then /^the option "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)" (?:is|should be) selected$/
     * @Then /^"(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)" (?:is|should be) selected$/
     *
     * @return void
     * @throws ElementNotFoundException
     * @throws \Behat\Mink\Exception\ExpectationException
     */
    public function theOptionFromShouldBeSelected($option, $select)
    {
        $selectField = $this->getSession()->getPage()->findField($select);
        if (null === $selectField) {
            throw new ElementNotFoundException($this->getSession(), 'select field', 'id|name|label|value', $select);
        }
        $optionField = $selectField->find('named', array(
            'option',
            $option,
        ));
        if (null === $optionField) {
            throw new ElementNotFoundException($this->getSession(), 'select option field', 'id|name|label|value', $option);
        }

        if (!$optionField->isSelected()) {
            throw new ExpectationException('Select option field with value|text "'.$option.'" is not selected in the select "'.$select.'"', $this->getSession());
        }
    }
}
