<?php

namespace WP\WhitepaperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WhitepaperEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'textarea')
            ->add('publishedOn', 'date')
            ->add('editor', 'entity', array(
                'class'    => 'WPWhitepaperBundle:Editor',
                'property' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => false
            ))
            ->add('published', 'checkbox', array('required'=>false))
            ->add('send', 'submit', array('label'=>'Enregistrer', 'attr' => array('class'=>'btn btn-success')))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wp_whitepaperbundle_whitepaper_edit';
    }

    public function getParent()
    {
        return new WhitepaperType();
    }
}
