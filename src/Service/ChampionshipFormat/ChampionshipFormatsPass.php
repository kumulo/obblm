<?php

namespace App\Service\ChampionshipFormat;

use App\Service\ChampionshipService;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

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
