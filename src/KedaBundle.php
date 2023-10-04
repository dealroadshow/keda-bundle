<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle;

use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\TriggerBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class KedaBundle extends AbstractBundle
{
    public const TAG_TRIGGER_BUILDER = 'dealroadshow_keda.trigger_builder';
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('Resources/config/services.yaml');
        $builder
            ->registerForAutoconfiguration(TriggerBuilderInterface::class)
            ->addTag(self::TAG_TRIGGER_BUILDER);
    }
}
