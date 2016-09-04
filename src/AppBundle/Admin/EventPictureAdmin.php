<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class EventPictureAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('realName', 'text', array('read_only' => true, 'disabled' => true))
            ->add('file', 'file', array('required' => false))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('realName')
            ->add('event')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('event')
            ->add('realName')
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

    public function prePersist($picture)
    {
        $this->manageFileUpload($picture);
    }

    public function preUpdate($picture)
    {
        $this->manageFileUpload($picture);
    }

    public function postRemove($picture)
    {
        $picture->remove();
    }

    private function manageFileUpload($picture)
    {
        if ($picture->getFile()) {
            $picture->upload();
        }
    }
}
