<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class ChangePasswordType extends AbstractType
{
    /**
     * @var PasswordEncoder
     */
    private $encoder;

    public function __construct(UserPasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', PasswordType::class, array(
                'label' => 'Ancien mot de passe'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer le mot de passe'),
                'invalid_message' => 'Vous n\'avez pas entré deux fois le même mot de passe.'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ))
            ->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
                $form = $event->getForm();
                $user = $event->getData();

                if (!$form->isValid()) {
                    return;
                }

                if (!$this->encoder->isPasswordValid($user, $form->get('currentPassword')->getData())) {
                    $error = new FormError('Mauvais mot de passe, veuillez réessayer.');
                    $form->get('currentPassword')->addError($error);
                }
            })
        ;
    }
}
