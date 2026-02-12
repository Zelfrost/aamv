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
                    'Dimanche' => 'Dimanche',
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
            ->add('showPhoneNumber', ChoiceType::class, [
                'label' => "Souhaitez vous afficher votre numéro de téléphone dans l'annonce ?",
                'expanded' => true,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('showEmail', ChoiceType::class, [
                'label' => "Souhaitez vous afficher votre adresse email dans l'annonce ?",
                'expanded' => true,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-success w-100'
                )
            ))
        ;

        if (null !== $options['data']
            && null !== $options['data']->getCreatedAt()
            && $options['data']->getCreatedAt() < (new \DateTime())->sub(new \DateInterval('P1M'))
        ) {
            $builder->add('revalidate', SubmitType::class, [
                'label' => 'Re-valider',
                'attr' => [
                    'class' => 'btn btn-info w-100'
                ]
            ]);
        }
    }
}