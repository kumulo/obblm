<?php

namespace BbLigueBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BbLigueBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
