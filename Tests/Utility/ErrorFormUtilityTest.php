<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Utility;

use Chaplean\Bundle\CmsBundle\Utility\ErrorFormUtility;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

/**
 * ErrorFormUtilityTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class ErrorFormUtilityTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\ErrorFormUtility::getErrorsForAngular()
     *
     * @return void
     */
    public function testGetErrorsForm()
    {
        $form = \Mockery::mock(FormInterface::class);
        $form->shouldReceive('getName')
            ->once()
            ->andReturn('category');

        $error = new FormError('Ce champs est requis');
        $error->setOrigin($form);

        $errors = [
            $error
        ];

        $errorsAngular = ErrorFormUtility::getErrorsForAngular($errors, 'chaplean_cms_post_form');

        $this->assertEquals(
            [
                'chaplean_cms_post_form[category]' => 'Ce champs est requis'
            ],
            $errorsAngular
        );
    }
}
