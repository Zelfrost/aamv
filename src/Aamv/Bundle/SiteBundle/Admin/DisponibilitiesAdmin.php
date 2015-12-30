<?php

namespace Aamv\Bundle\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class DisponibilitiesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('childminder', 'entity', array(
                'class' => 'Aamv\Bundle\SiteBundle\Entity\User',
                'property' => 'fullname',
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder('u')
                        ->where('u.roles LIKE :role')
                        ->setParameter('role', '%ROLE_ASSISTANTE%')
                        ->add('orderBy', 'u.name ASC')
                        ->add('orderBy', 'u.firstname ASC');
                }
            ))
            ->add('numberOfChildren', 'number')
            ->add('startAt', 'text', array(
                'attr' => array(
                    'class' => 'month-picker',
                    'placeholder' => 'mm/aaaa'
                )
            ))
            ->add('endAt', 'sonata_type_date_picker', array(
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'placeholder' => 'jj/mm/aaaa'
                )
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('childminder.name')
            ->add('childminder.firstname')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('childminder.fullname')
            ->add('numberOfChildren')
        ;
    }

    public function getSecurityContext()
    {
        return $this->securityContext;
    }

    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }
}
