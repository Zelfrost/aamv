<?php

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom',
            ))
            ->add('position', NumberType::class, array(
                'label' => 'Position',
            ))
            ->add('orderField', ChoiceType::class, array(
                'label' => 'Trier les documents par :',
                'choices' => ['Nom' => 'name', 'Date' => 'date'],
            ))
            ->add('forMembers', CheckboxType::class, array(
                'label' => 'Réservée aux membres',
                'required' => false,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success',
                ),
            ));
        ;
    }
}