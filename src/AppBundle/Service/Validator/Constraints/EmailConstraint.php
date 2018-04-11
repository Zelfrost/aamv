<?php

namespace AppBundle\Service\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailConstraint extends Constraint
{
    public $messageUnauthorize = 'Les adresses emails en @aamv.net ne sont pas autorisées';
    public $messageWrongCharacter = 'Les + ne sont pas autorisés dans les adresses emails';

    public function validatedBy()
    {
        return 'email_validator';
    }
}