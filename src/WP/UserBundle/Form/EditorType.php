<?php

namespace WP\UserBundle\Form;

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
//            ->add('name', 'text')
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('company', 'text')
            ->add('phone', 'text')
            ->add('bio', 'textarea', array('required'=>false))
            ->add('website', 'url', array('required'=>false))
            ->add('facebook', 'url', array('required'=>false))
            ->add('twitter', 'text', array('required'=>false))
            ->add('save', 'submit', array('label'=>'S\'inscrire', 'attr' => array('class'=>'btn btn-success')))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wp_userbundle_editor';
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }
}
