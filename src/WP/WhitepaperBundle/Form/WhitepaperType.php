<?php

namespace WP\WhitepaperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WhitepaperType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('publishedOn', 'date')
            ->add('send', 'submit', array('label'=>'Ajouter', 'attr' => array('class'=>'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WP\WhitepaperBundle\Entity\Whitepaper'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wp_whitepaperbundle_whitepaper';
    }
}
