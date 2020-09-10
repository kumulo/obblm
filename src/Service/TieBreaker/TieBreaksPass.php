<?php

namespace BBlm\Service\TieBreaker;

use BBlm\Service\TieBreakService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TieBreaksPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(TieBreakService::class);

        foreach ($container->findTaggedServiceIds('bblm.tiebreaks') as $id => $tags) {
            $definition->addMethodCall('addTieBreak', [new Reference($id)]);
        }
    }
}
