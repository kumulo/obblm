<?php

namespace BbLigueBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use BbLigueBundle\DependencyInjection\Configuration;

class BbLigueExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('bb_ligue.rules', $config['rules']);
        
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
    public function prepend( ContainerBuilder $container )
    {
        // Loading our YAML file containing our template rules
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('lrb6/rules.yml');
        $loader->load('lrb6/rosters/amazon.yml');
        $loader->load('lrb6/rosters/dark_elf.yml');
        $loader->load('lrb6/rosters/dwarf.yml');
        $loader->load('lrb6/rosters/goblin.yml');
        $loader->load('lrb6/rosters/halfling.yml');
        $loader->load('lrb6/rosters/high_elf.yml');
        $loader->load('lrb6/rosters/human.yml');
        $loader->load('lrb6/rosters/necromantic.yml');
        $loader->load('lrb6/rosters/ogre.yml');
        $loader->load('lrb6/star-players.yml');
    }
}
