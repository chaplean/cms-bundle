<?php

namespace Chaplean\Bundle\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
class PageRouteType extends AbstractType
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
            ->add('path', TextType::class, array(
                'required' => true
            ))
            ->add('menuName', TextType::class, array(
                'required' => true
            ))
            ->add('rollover', TextType::class, array(
                'required' => false
            ))
            ->add('page', new PageType())
            ->add('publication', new PublicationType());
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
    public function getBlockPrefix()
    {
        return 'chaplean_cms_page_route_form';
    }
}
