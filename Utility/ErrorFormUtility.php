<?php

namespace Chaplean\Bundle\CmsBundle\Utility;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;

/**
 * ErrorFormUtility.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class ErrorFormUtility
{
    /**
     * @param FormErrorIterator|array $errors
     * @param string                  $formName
     *
     * @return array
     */
    public static function getErrorsForAngular($errors, $formName)
    {
        $errorsAngular = array();

        /** @var FormError $error */
        foreach ($errors as $error) {
            $message = $error->getMessage();
            $field = $error->getOrigin()->getName();

            $errorsAngular += array(
                $formName . '[' . $field . ']' => $message
            );
        }

        return $errorsAngular;
    }
}
