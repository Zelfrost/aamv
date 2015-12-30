<?php

namespace Aamv\Bundle\SiteBundle\Retriever;

class Role
{
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function getNameFromUser($user)
    {
        return $this->context->isGranted($user, 'ROLE_PARENT') ? 'parents' : 'assistantes';
    }

    public function getRoleFromName($name)
    {
        return $name === 'parent' ? 'ROLE_PARENT' : "ROLE_ASSISTANTE";
    }
}
