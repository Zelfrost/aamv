<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Category;
use AppBundle\Entity\Tool;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ToolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom',
            ))
            ->add('category', EntityType::class, array(
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $repository) use ($options) {
                    return $repository->queryForOrdered($options['attr']['type']);
                },
                'required' => false,
            ))
            ->add('date', DateType::class, array(
                'label' => 'Date (ne remplir que pour les documents à trier par date)',
                'format' => 'dd-MMMM-yyyy',
                'required' => false,
                'choice_translation_domain' => 'FR'
            ))
            ->add('file', FileType::class, array(
                'label' => 'Fichier',
                'required' => false,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-success w-100',
                ),
            ));
        ;
    }
}