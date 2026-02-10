<?php

namespace AppBundle\Form\Type;

use AppBundle\Repository\CityRepository;
use AppBundle\Service\Retriever\CityRetriever;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegisterType extends AbstractType
{
    private $cityRetriever;
    private $repository;

    public function __construct(CityRetriever $cityRetriever, CityRepository $repository)
    {
        $this->cityRetriever = $cityRetriever;
        $this->repository = $repository;
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
            ->add('phoneNumber', TextType::class, array(
                'label' => 'Numéro de téléphone',
                'required' => false
            ))
            ->add('email', TextType::class, array(
                'label' => 'Email'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer le mot de passe'),
            ))
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Assistante Maternelle' => 'assistante',
                    'Parent' => 'parent',
                    'En recherche de stage' => 'trainee',
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
            ->add('rgpdConsent', CheckboxType::class, array(
                'mapped' => false,
                'required' => true,
                'label' => 'J\'accepte la politique de confidentialité',
                'constraints' => array(
                    new IsTrue(array(
                        'message' => 'Vous devez accepter la politique de confidentialité pour vous inscrire.',
                    )),
                ),
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
                    'class' => 'select2 city form-control'
                ),
                'choices' => [
                    $data['city'] => $data['city'],
                ]
            ))
            ->add('neighborhood', ChoiceType::class, array(
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