<?php

namespace AppBundle\Service\Retriever;

class Role
{
    private $authorizationChecker;

    public function __construct($authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function getNameFromUser($user)
    {
        return $this->authorizationChecker->isGranted('ROLE_PARENT') ? 'parent' : 'assistante';
    }

    public function getRoleFromName($name)
    {
        return $name === 'parent' ? 'ROLE_PARENT' : 'ROLE_ASSISTANTE';
    }

    public function getOppositeNameFromUser($user)
    {
        return $this->authorizationChecker->isGranted('ROLE_ASSISTANTE') ? 'parent' : 'assistante';
    }
}
