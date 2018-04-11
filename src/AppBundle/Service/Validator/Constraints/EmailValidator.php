<?php

namespace AppBundle\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $values = explode('@', $value);

        if (strpos($values[0], '+')) {
            $this->context->buildViolation($constraint->messageWrongCharacter)->addViolation();
        }

        if ($values[1] === 'aamv.net') {
            $this->context->buildViolation($constraint->messageUnauthorize)->addViolation();
        }
    }
}