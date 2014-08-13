<?php

namespace Ben\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BenUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
