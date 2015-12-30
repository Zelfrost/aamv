<?php

namespace Aamv\Bundle\SiteBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AamvSiteBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
