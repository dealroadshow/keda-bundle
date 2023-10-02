<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Fallback;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaledObject;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaleTargetReference;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\ScaleTrigger;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\ScaleTarget\WorkloadContainerReference;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator\BehaviorConfigurator;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ScaledObjectInterface extends ManifestInterface
{
    public function scaleTargetRef(): ScaleTargetReference|WorkloadContainerReference;
    public function pollingInterval(): int;
    public function cooldownPeriod(): int;
    public function idleReplicaCount(): int|null;
    public function minReplicaCount(): int;
    public function maxReplicaCount(): int;
    public function fallback(): Fallback|null;
    public function restoreToOriginalReplicaCount(): bool;
    public function hpaName(): string|null;
    public function behavior(BehaviorConfigurator $behavior): void;

    /**
     * @return ScaleTrigger[]
     */
    public function triggers(): iterable;
    public function configureScaledObject(ScaledObject $scaledObject): void;
}
