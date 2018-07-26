<?php

namespace BbLeagueBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use BbLeagueBundle\Services\TieBreaks\TieBreaksPass;

class BbLeagueBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TieBreaksPass());
    }
}
