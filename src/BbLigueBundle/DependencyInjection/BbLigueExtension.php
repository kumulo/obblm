<?php

namespace BbLigueBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use BbLigueBundle\DependencyInjection\Configuration;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
/*
KW : symfony load yml datas
VOiR : http://www.strangebuzz.com/post/2012/01/28/Load-fixtures-with-Symfony2
*/
class BbLigueExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('bb_ligue.rostervars', $config['rosters']);
        
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
    public function prepend( ContainerBuilder $container )
    {
        // Loading our YAML file containing our template rules
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('rosters/dwarves.yml');
        $loader->load('rosters/halfings.yml');
    }
}
