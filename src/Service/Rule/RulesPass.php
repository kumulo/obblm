<?php

namespace BBlm\Service\Rule;

use BBlm\Service\RuleService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RulesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(RuleService::class);

        foreach ($container->findTaggedServiceIds('bblm.rules_helper') as $id => $tags) {
            $definition->addMethodCall('addRule', [new Reference($id)]);
        }
    }
}
