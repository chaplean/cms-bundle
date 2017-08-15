<?php

namespace Chaplean\Bundle\CmsBundle\Form\Type;

use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PublicationType.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
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
        $builder->add(
            'datePublicationBegin',
            DateTimeType::class,
            [
                'required' => false,
                'widget'   => 'single_text',
            ]
        )
            ->add(
                'datePublicationEnd',
                DateTimeType::class,
                [
                    'required' => false,
                    'widget'   => 'single_text',
                ]
            )
            ->add(
                'isHighlighted',
                ChoiceType::class,
                [
                    'choices'           => [
                        'no'  => 0,
                        'yes' => 1,
                    ],
                    'choices_as_values' => true,
                    'multiple'          => false,
                    'expanded'          => true,
                    'required'          => false,
                    'empty_data'        => '0',
                ]
            )
            ->add(
                'status',
                EntityType::class,
                [
                    'class'        => 'ChapleanCmsBundle:PublicationStatus',
                    'choice_label' => 'id',
                    'required'     => true,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver Resolver.
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => Publication::class,
                'translation_domain' => 'messages',
                'csrf_protection'    => false,
            ]
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'chaplean_cms_publication_form';
    }
}
