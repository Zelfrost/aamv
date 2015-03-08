<?php

namespace Aamv\Bundle\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label'    => 'Titre',
                'attr'     => array(
                    'placeholder' => 'Le titre de la news'
                )
            ))
            ->add('content', 'textarea', array(
                'label'    => 'Contenu',
                'attr'     => array(
                    'rows'        => 10,
                    'placeholder' => 'Le contenu de la news'
                )
            ))
            ->add('Valider', 'submit', array(
                'attr'     => array(
                    'class'       => 'btn btn-success btn-block'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Aamv\Bundle\SiteBundle\Entity\News',
        ));
    }

    public function getName()
    {
        return 'news_form';
    }
}
