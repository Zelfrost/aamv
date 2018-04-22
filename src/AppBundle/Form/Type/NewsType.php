<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('content', TextareaType::class, array(
                'label' => 'Contenu',
                'attr' => array(
                    'class' => 'ckeditor'
                )
            ))
            ->add('important', ChoiceType::class, [
                'label' => 'Cette news est importante',
                'expanded' => true,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider',
                'attr' => array('class' => 'btn btn-info btn-block')
            ))
        ;
    }
}
