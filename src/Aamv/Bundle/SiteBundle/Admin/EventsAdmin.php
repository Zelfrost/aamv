<?php

namespace Aamv\Bundle\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

class EventsAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('description', 'textarea', array('attr' => array('class' => 'ckeditor')))
            ->add('date', 'sonata_type_date_picker', array('format' => 'dd/MM/yyyy'))
            ->add('eventPictures', 'sonata_type_collection',
                array('by_reference' => false),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'id',
                )
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('date', 'doctrine_orm_datetime', array(
                'field_type' => 'sonata_type_date_picker',
                'field_options' => array('format' => 'dd/MM/yyyy')
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name')
            ->add('date')
        ;
    }

    public function prePersist($event)
    {
        foreach ($event->getEventPictures() as $picture) {
            $this->manageFileUpload($picture);
        }
    }

    public function preUpdate($event)
    {
        foreach ($event->getEventPictures() as $picture) {
            $this->manageFileUpload($picture);
        }
    }

    public function preRemove($event)
    {
        foreach ($event->getEventPictures() as $picture) {
            $picture->remove();
        }
    }

    private function manageFileUpload($picture)
    {
        if ($picture->getFile()) {
            $picture->upload();
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
