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
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
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
    public function __construct($config)
    {
        $this->categories = array();

        if (is_bool($config) && $config) {
            $this->categories = array(
                'news'        => 'post.category.news',
                'testimonial' => 'post.category.testimonial',
                'video'       => 'post.category.video',
                'zoom'        => 'post.category.zoom',
            );
        } elseif (is_array($config)) {
            if (!in_array('news', $config)) {
                $this->categories += array('news' => 'post.category.news');
            }

            foreach ($config as $category) {
                PostUtility::getClassByInstance($category);
                $this->categories += array($category => 'post.category.' . $category);
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
        $options = null;
        $builder
            ->add('category', ChoiceType::class, array(
                'mapped' => false,
                'choices' => $this->categories,
                'empty_data' => 'news',
                'required' => true
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
            'data_class' => 'Chaplean\Bundle\CmsBundle\Entity\Post',
            'translation_domain' => 'messages',
            'csrf_protection' => false,
        ));
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
