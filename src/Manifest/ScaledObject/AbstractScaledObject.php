<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Fallback;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaledObject;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\TriggerBuildersRegistry;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\BehaviorConfigurator;

abstract class AbstractScaledObject extends AbstractManifest implements ScaledObjectInterface
{
    public static function apiVersion(): string
    {
        return ScaledObject::API_VERSION;
    }

    public static function kind(): string
    {
        return ScaledObject::KIND;
    }

    public function pollingInterval(): int
    {
        return 30;
    }

    public function cooldownPeriod(): int
    {
        return 300;
    }

    public function idleReplicaCount(): int|null
    {
        return null;
    }

    public function minReplicaCount(): int
    {
        return 0;
    }

    public function maxReplicaCount(): int
    {
        return 100;
    }

    public function fallback(): Fallback|null
    {
        return null;
    }

    public function restoreToOriginalReplicaCount(): bool|null
    {
        return null;
    }

    public function hpaName(): string|null
    {
        return null;
    }

    public function behavior(BehaviorConfigurator $behavior): void
    {
    }

    public function triggers(TriggerBuildersRegistry $builders): iterable
    {
        return [];
    }

    public function configureScaledObject(ScaledObject $scaledObject): void
    {
    }
}
