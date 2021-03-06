<?php

namespace Aamv\Bundle\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegistrationFormType extends AbstractType
{
    private $cityRetriever;

    public function __construct($cityRetriever)
    {
        $this->cityRetriever = $cityRetriever;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom :'
            ))
            ->add('firstname', 'text', array(
                'label' => 'Prénom :'
            ))
            ->add('phoneNumber', 'text', array(
                'label' => 'Numéro de téléphone :'
            ))
            ->add('baseRole', 'choice', array(
                'choices' => array(
                    'assistante' => 'Assistante Maternelle',
                    'parent' => 'Parent'
                ),
                'label' => 'Vous êtes :',
                'expanded' => true,
                'multiple' => false
            ))
            ->add('city', 'choice', array(
                'label' => 'Ville :',
                'attr' => array(
                    'class' => "select2 form-control"
                )
            ))
            ->add('neighborhood', 'choice', array(
                'label' => 'Quartier (seulement si vous êtes de Villeneuve d\'Ascq) :',
                'required' => false,
                'choices' =>  array_merge(array(
                    null => 'Choisissez un quartier',
                ), $this->cityRetriever->getNeighborhoods("Villeneuve-d'Ascq")),
                'attr' => array(
                    'class' => "form-control"
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ));

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $form->remove('city');
            $form->remove('neighborhood');
            $form->remove('submit');
            $form->add('city', 'choice', array(
                'label' => 'Ville :',
                'attr' => array(
                    'class' => "select2 form-control"
                ),
                'choices' => array(
                    $data['city'] => $data['city'],
                )
            ))
            ->add('neighborhood', 'choice', array(
                'label' => "Quartier (seulement si vous êtes de Villeneuve d'Ascq) :",
                'choices' => array_merge(array(
                    null => 'Choisissez un quartier',
                ), $this->cityRetriever->getNeighborhoods("Villeneuve-d'Ascq")),
                'attr' => array(
                    'class' => "form-control"
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ));
        });
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'aamv_user_registration';
    }
}