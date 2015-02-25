<?php

namespace WP\WhitepaperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditorEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('save', 'submit', array('label'=>'Enregistrer', 'attr' => array('class'=>'btn btn-success')))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wp_whitepaperbundle_editor_edit';
    }

    public function getParent()
    {
        return new EditorType();
    }
}
