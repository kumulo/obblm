<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TieBreaksPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('bblm.tiebreaks');

        foreach ($container->findTaggedServiceIds('bblm.tiebreaks') as $id => $tags) {
            $definition->addMethodCall('addTieBreak', [new Reference($id)]);
        }
    }
}
