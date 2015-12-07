<?php
namespace Chaplean\Bundle\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PublicationType.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */

class PublicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder Builder.
     * @param array                $options Options.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options = null;
        $builder
            ->add('datePublicationBegin', 'datetime', array(
                'required' => false,
                'widget'   => 'single_text',
            ))
            ->add('datePublicationEnd', 'datetime', array(
                'required' => false,
                'widget'   => 'single_text',
            ))
            ->add('isHighlighted', 'choice', array(
                'choices' => array(
                    '0' => 'no',
                    '1' => 'yes',
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => false,
                'empty_data' => '0',
            ))
            ->add('status', 'entity', array(
                'class'    => 'Chaplean\Bundle\CmsBundle\Entity\PublicationStatus',
                'property' => 'id',
                'required' => true,
            ));
    }

    /**
     * @param OptionsResolver $resolver Resolver.
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Chaplean\Bundle\CmsBundle\Entity\Publication',
            'translation_domain' => 'messages',
            'csrf_protection' => false,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'chaplean_cms_publication_form';
    }
}
