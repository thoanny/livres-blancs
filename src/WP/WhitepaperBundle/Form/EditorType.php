<?php

namespace WP\WhitepaperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('website', 'url', array('required'=>false))
            ->add('facebook', 'url', array('required'=>false))
            ->add('twitter', 'text', array('required'=>false))
            ->add('email', 'email', array('required'=>false))
            ->add('description', 'textarea', array('required'=>false))
            ->add('phone', 'text', array('required'=>false))
            ->add('save', 'submit', array('label'=>'Ajouter', 'attr' => array('class'=>'btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WP\WhitepaperBundle\Entity\Editor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wp_whitepaperbundle_editor';
    }
}
