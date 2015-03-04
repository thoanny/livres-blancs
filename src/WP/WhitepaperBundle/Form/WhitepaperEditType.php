<?php

namespace WP\WhitepaperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use WP\UserBundle\Entity\UserRepository;

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
            ->add('user', 'entity', array(
                'class'    => 'WPUserBundle:User',
                'property' => 'company',
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'query_builder' => function(UserRepository $ur) {


                        return $ur->createQueryBuilder('u')
                            ->where('u.enabled', '1')
                            ->where('u.roles LIKE :roles')
                            ->setParameter('roles', '%ROLE_EDITOR%')
                            ->orderBy('u.company', 'ASC');
                    },
            ))
            ->add('lang', 'language', array( 'required' => false,'preferred_choices' => array('fr', 'en', 'de', 'it', 'es') ))
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
