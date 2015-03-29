<?php

namespace Aamv\Bundle\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class NewsAdmin extends Admin
{
    private $securityContext;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text')
            ->add('content', 'textarea', array('attr' => array('class' => 'ckeditor')))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('author')
            ->add('createdAt')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('author')
            ->add('createdAt')
        ;
    }

    public function prePersist($news)
    {
        $news->setAuthor($this->getSecurityContext()->getToken()->getUser());
    }

    public function preUpdate($news)
    {
        $news->setUpdatedAt(new \DateTime());
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
