<?php

namespace AppBundle\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CityFromApiConstraint extends Constraint
{
    public $cityMessage = "Vous devez entrer votre ville en utilisant la liste.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
