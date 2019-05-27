<?php
namespace Corley\MaintenanceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('corley_maintenance');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('corley_maintenance');
        }

        $rootNode
            ->children()
                ->scalarNode("page")->defaultValue(__DIR__ . "/../Resources/views/maintenance.html")->end()
                ->scalarNode("web")->defaultValue('%kernel.root_dir%/../web')->end()
                ->scalarNode("soft_lock")->defaultValue('soft.lock')->end()
                ->scalarNode("hard_lock")->defaultValue('hard.lock')->end()
                ->booleanNode("symlink")->defaultFalse()->end()
                ->arrayNode("whitelist")
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('paths')
                            ->defaultValue(array())
                        ->end()
                        ->variableNode('ips')
                            ->defaultValue(array())
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
