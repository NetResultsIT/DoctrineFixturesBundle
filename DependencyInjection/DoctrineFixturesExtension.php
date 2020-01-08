<?php


namespace Doctrine\Bundle\FixturesBundle\DependencyInjection;

use Doctrine\Bundle\FixturesBundle\DependencyInjection\CompilerPass\FixturesCompilerPass;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DoctrineFixturesExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));

        $loader->load('services.xml');

        $container->registerForAutoconfiguration(ORMFixtureInterface::class)
            ->addTag(FixturesCompilerPass::FIXTURE_TAG);

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $purgerConfigLoaderDefition = $container->getDefinition('doctrine.fixtures.purger_config_loader');

        foreach ($config['exclude'] as $excludedTable) {
            $purgerConfigLoaderDefition->addMethodCall('addExcludedTable', [$excludedTable]);
        }
    }
}
