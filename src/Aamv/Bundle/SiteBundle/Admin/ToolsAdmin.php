<?php

namespace Aamv\Bundle\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class ToolsAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('fromAamv', 'checkbox', array('required' => false))
            ->add('file', 'file', array('required' => false))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('fromAamv')
            ->add('realName')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('fromAamv')
            ->add('realName')
        ;
    }

    public function prePersist($tool) {
        $this->manageFileUpload($tool);
    }

    public function preUpdate($tool) {
        $tool->refreshUpdated();
        $this->manageFileUpload($tool);
    }

    public function postRemove($tool) {
        $tool->remove();
    }

    private function manageFileUpload($tool) {
        if ($tool->getFile()) {
            $tool->upload();
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