<?php

namespace AppBundle\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CityFromApiValidator extends ConstraintValidator
{
    private $cityRetriever;

    public function __construct($cityRetriever)
    {
        $this->cityRetriever = $cityRetriever;
    }

    public function validate($entity, Constraint $constraint)
    {
        $cities = $this->cityRetriever->retrieve($entity->getCity());
        if (count($cities) === 0) {
            $this->context->buildViolation($constraint->cityMessage)->addViolation();

            return;
        }

        $exists = false;

        foreach ($cities as $city) {
            if ($city['text'] === $entity->getCity()) {
                $exists = true;
            }
        }

        if (!$exists) {
            $this->context->buildViolation($constraint->cityMessage)->addViolation();
        }
    }
}
