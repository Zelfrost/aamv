<?php

namespace Aamv\Bundle\SiteBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CityFromApi extends Constraint
{
    public $cityMessage = "Vous devez entrer votre ville en utilisant la liste.";

    public function validatedBy()
    {
        return "city_from_api";
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
