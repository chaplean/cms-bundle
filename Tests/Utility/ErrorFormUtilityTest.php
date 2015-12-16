<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Utility;

use Chaplean\Bundle\CmsBundle\Form\Type\PostType;
use Chaplean\Bundle\CmsBundle\Utility\ErrorFormUtility;
use Chaplean\Bundle\UnitBundle\Test\LogicalTest;
use Symfony\Component\Form\FormError;

/**
 * ErrorFormUtilityTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class ErrorFormUtilityTest extends LogicalTest
{
    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * @return void
     */
    public function testGetErrorsForm()
    {
        $formFactory = $this->getContainer()->get('form.factory');
        $form = $formFactory->create(PostType::class);

        $error = new FormError('Ce champs est requis');
        $error->setOrigin($form->get('category'));

        $errors = array(
            $error
        );

        $errorsAngular = ErrorFormUtility::getErrorsForAngular($errors, $form->getName());

        $this->assertEquals(array(
            'chaplean_cms_post_form[category]' => 'Ce champs est requis'
        ), $errorsAngular);
    }
}
