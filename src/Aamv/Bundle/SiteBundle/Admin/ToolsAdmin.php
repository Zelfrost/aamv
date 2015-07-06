<?php

namespace Aamv\Bundle\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ToolsAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('fromAamv', 'checkbox', array('required' => false))
            ->add('file', 'file')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('fromAecf')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('fromAecf')
        ;
    }

    public function prePersist($tools) {
        $this->manageFileUpload($tools);
    }

    public function preUpdate($tools) {
        $tools->refreshUpdated();
        $this->manageFileUpload($tools);
    }

    private function manageFileUpload($tools) {
        if ($tools->getFile()) {
            $tools->upload();
        }
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