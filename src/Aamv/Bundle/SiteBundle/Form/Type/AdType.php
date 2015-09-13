<?php

namespace Aamv\Bundle\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
                'label' => 'Titre :'
            ))
            ->add('content', 'textarea', array(
                'label' => 'Contenu :',
                'attr' => array(
                    'class' => 'ckeditor'
                )
            ))
            ->add('disponibilityDate', 'date', array(
                'label' => 'Période de début de disponibilité :',
                'widget' => 'choice',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTime(),
                'years' => range(date('Y'), date('Y') + 10),
            ))
            ->add('wishedDays', 'choice', array(
                'label' => 'Jours de garde souhaités :',
                'choices' => array(
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                ),
                'expanded' => true,
                'multiple' => true
            ))
            ->add('type', 'choice', array(
                'label' => 'Type de garde :',
                'choices' => array(
                    'day' => 'Journée',
                    'night' => 'Nuit'
                ),
                'expanded' => false,
                'multiple' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Aamv\Bundle\SiteBundle\Entity\Ad',
        ));
    }

    public function getName()
    {
        return 'aamv_site_create_ad';
    }
}