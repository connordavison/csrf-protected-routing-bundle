<?php

namespace Davison\CsrfProtectedRoutingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class CsrfProtectedRoutingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->loadServices($container);
        $this->configureServices($configs, $container);
    }

    private function loadServices(ContainerBuilder $container)
    {
        $locator = new FileLocator(__DIR__ . '/../Resources/config');
        $loader = new XmlFileLoader($container, $locator);
        $loader->load('services.xml');
    }

    private function configureServices(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('csrf_protected_routing.request_parameter', $config['request_parameter']);
        $container->setParameter('csrf_protected_routing.token_id', $config['token_id']);
        $container->setParameter('csrf_protected_routing.routes', $config['routes'] ?? []);
    }
}