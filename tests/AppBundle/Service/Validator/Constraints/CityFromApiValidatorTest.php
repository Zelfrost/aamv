<?php

namespace AppBundle\Service\Validator\Constraints;

use AppBundle\Service\Validator\Constraints\CityFromApiConstraint;
use AppBundle\Service\Validator\Constraints\CityFromApiValidator;
use \Mockery as m;

class CityFromApiValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNoCity()
    {
        $retriever = m::mock('AppBundle\Service\Retriever\CityRetriever');
        $retriever->shouldReceive('retrieve')->with('Bourg Palette')->once()->andReturn([]);

        $violationBuilder = m::mock('Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface');
        $violationBuilder->shouldReceive('addViolation')->withNoArgs()->once();

        $context = m::mock('Symfony\Component\Validator\Context\ExecutionContextInterface');
        $context->shouldReceive('buildViolation')->with('Not a valid city')->once()->andReturn($violationBuilder);

        $entity = m::mock('AppBundle\Entity\User');
        $entity->shouldReceive('getCity')->once()->andReturn('Bourg Palette');

        $constraint = m::mock('AppBundle\Service\Validator\Constraints\CityFromApiConstraint');
        $constraint->cityMessage = 'Not a valid city';

        $validator = new CityFromApiValidator($retriever);
        $validator->initialize($context);
        $validator->validate($entity, $constraint);
    }

    public function testCityNotMatching()
    {
        $retriever = m::mock('AppBundle\Service\Retriever\CityRetriever');
        $retriever->shouldReceive('retrieve')->with('Bourg Palette')->once()->andReturn([[
            'id' => 'New Bourg Palette',
            'text' => 'New Bourg Palette'
        ]]);

        $violationBuilder = m::mock('Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface');
        $violationBuilder->shouldReceive('addViolation')->withNoArgs()->once();

        $context = m::mock('Symfony\Component\Validator\Context\ExecutionContextInterface');
        $context->shouldReceive('buildViolation')->with('Not a valid city')->once()->andReturn($violationBuilder);

        $entity = m::mock('AppBundle\Entity\User');
        $entity->shouldReceive('getCity')->once()->andReturn('Bourg Palette');

        $constraint = m::mock('AppBundle\Service\Validator\Constraints\CityFromApiConstraint');
        $constraint->cityMessage = 'Not a valid city';

        $validator = new CityFromApiValidator($retriever);
        $validator->initialize($context);
        $validator->validate($entity, $constraint);
    }

    public function testValidCity()
    {
        $retriever = m::mock('AppBundle\Service\Retriever\CityRetriever');
        $retriever->shouldReceive('retrieve')->with('Bourg Palette')->once()->andReturn([[
            'id' => 'Bourg Palette',
            'text' => 'Bourg Palette'
        ]]);

        $context = m::mock('Symfony\Component\Validator\Context\ExecutionContextInterface');
        $context->shouldNotReceive('buildViolation');

        $entity = m::mock('AppBundle\Entity\User');
        $entity->shouldReceive('getCity')->once()->andReturn('Bourg Palette');

        $constraint = m::mock('AppBundle\Service\Validator\Constraints\CityFromApiConstraint');
        $constraint->cityMessage = 'Not a valid city';

        $validator = new CityFromApiValidator($retriever);
        $validator->initialize($context);
        $validator->validate($entity, $constraint);
    }
}
