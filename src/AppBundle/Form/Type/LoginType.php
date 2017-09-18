<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_email', TextType::class, array('label' => 'Email'))
            ->add('_password', PasswordType::class, array('label' => 'Mot de passe'))
            ->add('_remember_me', CheckboxType::class, array(
                'label' => 'Se souvenir de moi',
                'data' => true,
                'required' => false,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Confirmer',
                'attr' => array('class' => 'btn btn-success btn-block')
            ))
        ;
    }
}
