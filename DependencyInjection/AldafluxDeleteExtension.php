<?php

namespace Aldaflux\AldafluxDeleteBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class AldafluxDeleteExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) : void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        /*
        $container->setParameter( 'aldaflux_delete.parameter1', $config[ 'parameter1' ] );
        */

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
                
        
        
    }
}
