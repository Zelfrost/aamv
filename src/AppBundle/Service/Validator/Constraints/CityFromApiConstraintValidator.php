<?php

namespace AppBundle\Service\Validator\Constraints;

use AppBundle\Repository\CityRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CityFromApiConstraintValidator extends ConstraintValidator
{
    private $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validate($entity, Constraint $constraint)
    {
        $cities = $this->repository->findLike($entity->getCity());
        if (0 === count($cities)) {
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
