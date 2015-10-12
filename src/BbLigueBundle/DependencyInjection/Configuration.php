<?php

namespace BbLigueBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bb_ligue');
        $rootNode
            ->children()
                ->arrayNode( 'rules' )
                    ->useAttributeAsKey( 'name' )
                    ->prototype('array')
                        ->children()
                            ->integerNode('max_team_cost')->end( )
                            ->arrayNode( 'rosters' )
                                ->useAttributeAsKey( 'name' )
                                ->prototype('array')
                                    ->children()
                                        ->arrayNode( 'players' )
                                            ->prototype('array')
                                                ->children()
                                                    ->integerNode('min')->end( )
                                                    ->integerNode('max')->end( )
                                                    ->integerNode('move')->end( )
                                                    ->integerNode('force')->end( )
                                                    ->integerNode('agility')->end( )
                                                    ->integerNode('armor')->end( )
                                                    ->integerNode('cost')->end( )
                                                    ->arrayNode( 'skills' )
                                                        ->prototype('scalar')->end()
                                                    ->end( )
                                                    ->arrayNode( 'available_skills' )
                                                        ->prototype('scalar')->end()
                                                    ->end( )
                                                    ->arrayNode( 'available_skills_on_double' )
                                                        ->prototype('scalar')->end()
                                                    ->end( )
                                                ->end( )
                                            ->end( )
                                        ->end( )
                                        ->arrayNode( 'options' )
                                            ->children()
                                                ->integerNode('reroll_cost')->end( )
                                                ->arrayNode( 'available_champions' )
                                                    ->prototype('scalar')->end()
                                                ->end( )
                                                ->booleanNode('can_have_alchemist')
                                                    ->defaultTrue()
                                                ->end( )
                                                ->booleanNode('can_have_sorcerer')
                                                    ->defaultTrue()
                                                ->end( )
                                                ->booleanNode('can_have_igor')
                                                    ->defaultFalse()
                                                ->end( )
                                                ->booleanNode('can_have_halfing_kitchener')
                                                    ->defaultFalse()
                                                ->end( )
                                            ->end( )
                                        ->end( )
                                    ->end( )
                                ->end( )
                            ->end( )
                        ->end( )
                    ->end( )
                ->end( )
            ->end( )
        ->end( );
        

        return $treeBuilder;
    }
}
