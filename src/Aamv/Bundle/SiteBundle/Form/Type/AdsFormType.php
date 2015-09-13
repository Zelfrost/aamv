<?php

namespace Aamv\Bundle\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
                'label' => 'Titre :'
            ))
            ->add('content', 'textarea', array(
                'label' => 'Contenu :'
                'attr' => array(
                    'class' => 'ckeditor'
                )
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
                'expanded' => false,
                'multiple' => false,
                'attr' => array(
                    'class' => "select2 form-control"
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ));
    }

    public function getName()
    {
        return 'aamv_ads_create';
    }
}