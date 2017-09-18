<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Person;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DisponibilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('childminder', EntityType::class, array(
                'label' => 'Assistante maternelle',
                'class' => Person::class,
                'choice_label' => 'fullname',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->leftJoin('AppBundle\Entity\User', 'u', Expr\Join::WITH, 'u.id = p.id')
                        ->where('u.roles LIKE :role')
                        ->orWhere($er->createQueryBuilder('u')
                            ->expr()
                            ->isNull('u.roles')
                        )
                        ->setParameter('role', '%ROLE_ASSISTANT%')
                        ->orderBy('p.name', 'ASC')
                        ->addOrderBy('p.firstname', 'ASC')
                    ;
                }
            ))
            ->add('numberOfChildren', NumberType::class, array('label' => 'Nombre d\'enfants'))
            ->add('period', TextType::class, array('label' => 'Période'))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider',
                'attr' => array(
                    'class' => 'btn btn-block btn-success'
                )
            ))
        ;
    }
}
