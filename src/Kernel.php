<?php

namespace BBlm;

use BBlm\Service\ChampionshipFormat\ChampionshipFormatInterface;
use BBlm\Service\ChampionshipFormat\ChampionshipFormatsPass;
use BBlm\Service\Rule\RuleInterface;
use BBlm\Service\Rule\RulesPass;
use BBlm\Service\TieBreaker\TieBreakerInterface;
use BBlm\Service\TieBreaker\TieBreaksPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use function dirname;
use const PHP_VERSION_ID;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getProjectDir(): string
    {
        return dirname(__DIR__);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', PHP_VERSION_ID < 70400 || $this->debug);
        $container->setParameter('container.dumper.inline_factories', true);
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/'.$this->environment.'/*.yaml');
        $routes->import($confDir.'/{routes}/*.yaml');
        $routes->import($confDir.'/{routes}.yaml');
    }

    protected function build(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(TieBreakerInterface::class)
            ->addTag('bblm.tiebreaks')
        ;
        $container->registerForAutoconfiguration(ChampionshipFormatInterface::class)
            ->addTag('bblm.championship_format')
        ;
        $container->registerForAutoconfiguration(RuleInterface::class)
            ->addTag('bblm.rules_helper')
        ;
        $container->addCompilerPass(new TieBreaksPass());
        $container->addCompilerPass(new ChampionshipFormatsPass());
        $container->addCompilerPass(new RulesPass());
    }
}
