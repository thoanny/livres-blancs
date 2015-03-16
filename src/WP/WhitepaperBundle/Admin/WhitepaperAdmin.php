<?php

namespace WP\WhitepaperBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use WP\UserBundle\Entity\UserRepository;

class WhitepaperAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Post Title'))
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
            ->add('description') //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Here we set the fields of the ShowMapper variable, $showMapper (but this can be called anything)
        $showMapper
            ->add('title')
            ->add('description')
            ->add('published','boolean')
        ;

    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('user')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('user')
        ;
    }
}