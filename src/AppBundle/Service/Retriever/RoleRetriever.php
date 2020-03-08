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
        if ('assistante' === $name) {
            return User::ROLE_ASSISTANT;
        } elseif ('parent' === $name) {
            return User::ROLE_PARENT;
        }

        return User::ROLE_TRAINEE;
    }
}
