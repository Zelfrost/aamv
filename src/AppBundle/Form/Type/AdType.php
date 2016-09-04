<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
                'label' => 'Titre :'
            ))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenu :',
                'attr' => array(
                    'class' => 'ckeditor'
                )
            ))
            ->add('disponibilityDate', DateType::class, array(
                'label' => 'Période de début de disponibilité :',
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y'), date('Y') + 10),
            ))
            ->add('wishedDays', ChoiceType::class, array(
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
            ->add('type', ChoiceType::class, array(
                'label' => 'Type de garde :',
                'choices' => array(
                    'Journée' => 'day',
                    'Demi journée' => 'half',
                    'Périscolaire' => 'school'
                ),
                'expanded' => false,
                'multiple' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ))
        ;
    }
}