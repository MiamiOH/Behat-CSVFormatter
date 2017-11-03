<?php

namespace miamioh\BehatCSVFormatter;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class CSVFormatterExtension
 * @package Features\Formatter
 */
class BehatCSVFormatterExtension implements Extension
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        // TODO: Implement process() method.
    }

    /**
     * Returns the extension config key.
     *
     * @return string
     */
    public function getConfigKey()
    {
        // TODO: Implement getConfigKey() method.
        return "miamiohcsv";
    }

    /**
     * Initializes other extensions.
     *
     * This method is called immediately after all extensions are activated but
     * before any extension `configure()` method is called. This allows extensions
     * to hook into the configuration of other extensions providing such an
     * extension point.
     *
     * @param ExtensionManager $extensionManager
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // TODO: Implement initialize() method.
    }

    /**
     * Setups configuration for the extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {

      $builder->children()->scalarNode('filename')->defaultValue('test_report.xml');
      $builder->children()->scalarNode('outputDir')->defaultValue('build/tests');
      $builder->children()->scalarNode('columnList')->defaultValue('ScenarioName,Status');
      $builder->children()->scalarNode('delimiter')->defaultValue(',');
      $builder->children()->scalarNode('enclosure')->defaultValue("'");
      $builder->children()->scalarNode('writeMethod')->defaultValue('Append');
    }

    /**
     * Loads extension services into temporary container.
     *
     * @param ContainerBuilder $container
     * @param array $config
     */
    public function load(ContainerBuilder $container, array $config)
    {

      $definition = new Definition("miamioh\\BehatCSVFormatter\\Formatter\\CSVFormatter");
      $definition->addArgument($config['filename']);
      $definition->addArgument($config['outputDir']);
      $definition->addArgument($config['columnList']);
      $definition->addArgument($config['delimiter']);
      $definition->addArgument($config['enclosure']);
      $definition->addArgument($config['writeMethod']);
      $definition->addArgument('%paths.base%');
      $container->setDefinition("csv.formatter",$definition)->addTag("output.formatter");

    }
}
