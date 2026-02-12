<?php

use AppBundle\Service\Retriever\RoleRetriever;
use \Mockery as m;

class RoleRetrieverTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testParentUserGetRole()
    {
        $checker = m::mock('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface');

        $retriever = new RoleRetriever($checker);
        $this->assertEquals('ROLE_PARENT', $retriever->getRoleFromName('parent'));
    }

    public function testAssistanteUserGetRole()
    {
        $checker = m::mock('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface');

        $retriever = new RoleRetriever($checker);
        $this->assertEquals('ROLE_ASSISTANTE', $retriever->getRoleFromName('assistante'));
    }

    public function testRolelessUserGetRole()
    {
        $checker = m::mock('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface');

        $retriever = new RoleRetriever($checker);
        $this->assertEquals('ROLE_PARENT', $retriever->getRoleFromName('roleless'));
    }

    public function testParentUserGetOppositeName()
    {
        $checker = m::mock('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface');
        $checker->shouldReceive('isGranted')->with('ROLE_ASSISTANTE')->once()->andReturn(false);

        $retriever = new RoleRetriever($checker);
        $this->assertEquals('assistante', $retriever->getOppositeNameFromUser());
    }

    public function testAssistanteUserGetOppositeName()
    {
        $checker = m::mock('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface');
        $checker->shouldReceive('isGranted')->with('ROLE_ASSISTANTE')->once()->andReturn(true);

        $retriever = new RoleRetriever($checker);
        $this->assertEquals('parent', $retriever->getOppositeNameFromUser());
    }

    public function testRolelessUserGetOppositeName()
    {
        $checker = m::mock('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface');
        $checker->shouldReceive('isGranted')->with('ROLE_ASSISTANTE')->once()->andReturn('maybe');

        $retriever = new RoleRetriever($checker);
        $this->assertEquals('parent', $retriever->getOppositeNameFromUser());
    }
}
