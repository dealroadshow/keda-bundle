<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob;

use Dealroadshow\Bundle\KedaBundle\API\ScaledJob\ScaledJob;
use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\Configurator\RolloutConfigurator;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\Configurator\ScalingStrategyConfigurator;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\TriggerBuildersRegistry;
use Dealroadshow\K8S\Api\Batch\V1\JobSpec;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

interface ScaledJobInterface extends ManifestInterface
{
    public function jobTargetRef(): JobSpec;
    public function pollingInterval(): int;
    public function successfulJobsHistoryLimit(): int;
    public function failedJobsHistoryLimit(): int;
    public function envSourceContainerName(): ?string;
    public function minReplicaCount(): int;
    public function maxReplicaCount(): int;
    public function rollout(RolloutConfigurator $rollout): void;
    public function scalingStrategy(ScalingStrategyConfigurator $strategy): void;

    /**
     * @return Trigger[]
     */
    public function triggers(TriggerBuildersRegistry $builders): iterable;

    public function configureScaledJob(ScaledJob $scaledJob): void;
}
