<?php

namespace AppBundle\Form\Type;

use AppBundle\Service\Retriever\CityRetriever;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PersonType extends AbstractType
{
    private $cityRetriever;

    public function __construct(CityRetriever $cityRetriever)
    {
        $this->cityRetriever = $cityRetriever;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('email', TextType::class, array(
                'label' => 'Email'
            ))
            ->add('phoneNumber', TextType::class, array(
                'label' => 'Numéro de téléphone (sans points, ni virgules, exemple : 0123456789)',
                'required' => false
            ))
            ->add('city', ChoiceType::class, array(
                'label' => 'Ville',
                'attr' => array(
                    'class' => 'select2 city form-control'
                )
            ))
            ->add('neighborhood', ChoiceType::class, array(
                'label' => 'Quartier (seulement si vous êtes de Villeneuve d\'Ascq)',
                'required' => false,
                'choices' =>  array_merge(array(
                    null => 'Choisissez un quartier',
                ), $this->cityRetriever->getNeighborhoods()),
                'attr' => array(
                    'class' => 'form-control neighborhood'
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $form->remove('city');
            $form->remove('neighborhood');
            $form->remove('submit');

            if (array_key_exists('city', $data)) {
                $form->add('city', ChoiceType::class, array(
                    'label' => 'Ville',
                    'attr' => array(
                        'class' => 'select2 city form-control'
                    ),
                    'choices' => array(
                        $data['city'] => $data['city'],
                    )
                ));
            } else {
                $form->add('city', ChoiceType::class, array(
                    'label' => 'Ville',
                    'attr' => array(
                        'class' => 'select2 city form-control'
                    )
                ));
            }

            $form->add('neighborhood', ChoiceType::class, array(
                'label' => 'Quartier (seulement si vous êtes de Villeneuve d\'Ascq)',
                'choices' => array_merge(array(
                    null => 'Choisissez un quartier',
                ), $this->cityRetriever->getNeighborhoods()),
                'attr' => array(
                    'class' => 'form-control neighborhood'
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
