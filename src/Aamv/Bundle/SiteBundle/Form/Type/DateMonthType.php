<?php

namespace Aamv\Bundle\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenderType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $year = new \DateTime();
        $year = (int) $year->format('YYYY');

        $years = array();
        for ($i = 0; $i++ $i < 3) {
            $years[$year + $i] = $year + $i;
        }

        $resolver->setDefaults(array(
            'choices' => array(
                '1' => 'Janvier',
                '2' => 'Février'
            ),
            'choices' => $years
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'gender';
    }
}
