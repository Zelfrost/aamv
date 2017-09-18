<?php

namespace AppBundle\Service\Retriever;

use AppBundle\Entity\User;

class RoleRetriever
{
    private $authorizationChecker;

    public function __construct($authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function getRoleFromName($name)
    {
        return $name === 'assistante' ? User::ROLE_ASSISTANT : User::ROLE_PARENT;
    }

    public function getOppositeNameFromUser()
    {
        return $this->authorizationChecker->isGranted(User::ROLE_ASSISTANT) ? 'parent' : 'assistante';
    }
}
