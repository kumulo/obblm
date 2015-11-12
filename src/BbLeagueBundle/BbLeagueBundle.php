<?php

namespace BbLeagueBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BbLeagueBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
