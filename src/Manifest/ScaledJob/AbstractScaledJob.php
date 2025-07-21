<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob;

use Dealroadshow\Bundle\KedaBundle\API\ScaledJob\ScaledJob;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\Configurator\RolloutConfigurator;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\Configurator\ScalingStrategyConfigurator;
use Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\TriggerBuildersRegistry;
use Dealroadshow\K8S\Api\Batch\V1\JobSpec;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractScaledJob extends AbstractManifest implements ScaledJobInterface
{
    public function __construct(private readonly JobSpec $jobTargetRef)
    {
    }

    public function jobTargetRef(): JobSpec
    {
        return $this->jobTargetRef;
    }

    public static function apiVersion(): string
    {
        return ScaledJob::API_VERSION;
    }

    public static function kind(): string
    {
        return ScaledJob::KIND;
    }

    public function pollingInterval(): int
    {
        return 30;
    }

    public function successfulJobsHistoryLimit(): int
    {
        return 5;
    }

    public function failedJobsHistoryLimit(): int
    {
        return 5;
    }

    public function envSourceContainerName(): ?string
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

    public function rollout(RolloutConfigurator $rollout): void
    {
    }

    public function scalingStrategy(ScalingStrategyConfigurator $strategy): void
    {
    }

    public function triggers(TriggerBuildersRegistry $builders): iterable
    {
        return [];
    }

    public function configureScaledJob(ScaledJob $scaledJob): void
    {
    }
}
