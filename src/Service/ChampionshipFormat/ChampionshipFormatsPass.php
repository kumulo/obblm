<?php

namespace BBlm\Service\ChampionshipFormat;

use BBlm\Service\ChampionshipService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ChampionshipFormatsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(ChampionshipService::class);

        foreach ($container->findTaggedServiceIds('bblm.championship_format') as $id => $tags) {
            $definition->addMethodCall('addFormat', [new Reference($id)]);
        }
    }
}
