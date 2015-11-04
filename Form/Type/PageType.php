<?php

namespace Chaplean\Bundle\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType.
 *
 * @package   Chaplean\Bundle\CmsBundle\Form\Type
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder Builder.
     * @param array                $options Options.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            'text',
            array(
                'required' => true,
                'mapped' => false
            )
        )->add(
            'subtitle',
            'text',
            array(
                'required' => false,
                'mapped' => false
            )
        )->add(
            'path',
            'text',
            array(
                'required' => true
            )
        )->add(
            'menuName',
            'text',
            array(
                'required' => true
            )
        )->add(
            'rollover',
            'text',
            array(
                'required' => false
            )
        )->add(
            'metaDescription',
            'textarea',
            array(
                'required' => false,
                'mapped' => false,
                'attr' => array(
                    'rows' => 5
                )
            )
        )->add(
            'content',
            'textAngular',
            array(
                'required' => false,
                'mapped' => false
            )
        );
    }

    /**
     * @param OptionsResolver $resolver Resolver.
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Chaplean\Bundle\CmsBundle\Entity\PageRoute',
            'translation_domain' => 'messages',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cms_page';
    }
}
