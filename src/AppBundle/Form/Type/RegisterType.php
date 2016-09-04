<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegisterType extends AbstractType
{
    private $cityRetriever;

    public function __construct($cityRetriever)
    {
        $this->cityRetriever = $cityRetriever;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Login'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer le mot de passe'),
            ))
            ->add('email', TextType::class, array(
                'label' => 'Email'
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('phoneNumber', TextType::class, array(
                'label' => 'Numéro de téléphone',
                'required' => false
            ))
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Assistante Maternelle' => 'assistante',
                    'Parent' => 'parent'
                ),
                'attr' => array('class' => 'clearfix'),
                'label' => 'Vous êtes un/une',
                'mapped' => false,
                'expanded' => true,
                'multiple' => false
            ))
            ->add('city', ChoiceType::class, array(
                'label' => 'Ville',
                'attr' => array(
                    'class' => "select2 city form-control"
                )
            ))
            ->add('neighborhood', ChoiceType::class, array(
                'label' => 'Quartier (seulement si vous êtes de Villeneuve d\'Ascq)',
                'required' => false,
                'choices' =>  array_merge(array(
                    null => 'Choisissez un quartier',
                ), $this->cityRetriever->getNeighborhoods("Villeneuve-d'Ascq")),
                'attr' => array(
                    'class' => "form-control neighborhood"
                )
            ))
            ->add('submit', SubmitType::class, array(
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

            $form->add('city', ChoiceType::class, array(
                'label' => 'Ville',
                'attr' => array(
                    'class' => "select2 city form-control"
                ),
                'choices' => array(
                    $data['city'] => $data['city'],
                )
            ))
            ->add('neighborhood', ChoiceType::class, array(
                'label' => "Quartier (seulement si vous êtes de Villeneuve d'Ascq)",
                'choices' => array_merge(array(
                    null => 'Choisissez un quartier',
                ), $this->cityRetriever->getNeighborhoods("Villeneuve-d'Ascq")),
                'attr' => array(
                    'class' => "form-control"
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ));
        });
    }
}