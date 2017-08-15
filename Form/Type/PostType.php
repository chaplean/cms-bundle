<?php

namespace Chaplean\Bundle\CmsBundle\Form\Type;

use Chaplean\Bundle\CmsBundle\Utility\PostUtility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PostType.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PostType extends AbstractType
{
    /**
     * @var array
     */
    private $categories;

    /**
     * PostType constructor.
     *
     * @param mixed $config
     */
    public function __construct($config = null)
    {
        $this->categories = array();

        if (is_bool($config) && $config) {
            $this->categories = array(
                'post.category.news'        => 'news',
                'post.category.testimonial' => 'testimonial',
                'post.category.video'       => 'video',
                'post.category.zoom'        => 'zoom',
            );
        } elseif (is_array($config)) {
            if (!in_array('news', $config)) {
                $this->categories[] = array('post.category.news' => 'news');
            }

            foreach ($config as $category) {
                PostUtility::getClassByInstance($category);
                $this->categories[] = array('post.category.' . $category => $category);
            }
        }
    }

    /**
     * @param FormBuilderInterface $builder Builder.
     * @param array                $options Options.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'category',
            ChoiceType::class,
            [
                'mapped'            => false,
                'choices'           => $this->categories,
                'choices_as_values' => true,
                'empty_data'        => 'news',
                'required'          => true,
                'placeholder'       => 'post.category.choose'
            ]
        )
            ->add('page', PageType::class)
            ->add('publication', PublicationType::class);
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
                'data_class'         => 'Chaplean\Bundle\CmsBundle\Entity\Post',
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
        return 'chaplean_cms_post_form';
    }
}
