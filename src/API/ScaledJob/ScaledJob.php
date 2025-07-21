<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledJob;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;
use Dealroadshow\K8S\Api\Batch\V1\JobSpec;
use Dealroadshow\K8S\Apimachinery\Pkg\Apis\Meta\V1\ObjectMeta;
use Dealroadshow\K8S\APIResourceInterface;

class ScaledJob implements APIResourceInterface
{
    public const API_VERSION = 'keda.sh/v1alpha1';
    public const KIND = 'ScaledJob';

    private int $pollingInterval = 30;
    private int $successfulJobsHistoryLimit = 5;
    private int $failedJobsHistoryLimit = 5;
    private ?string $envSourceContainerName = null;
    private int $minReplicaCount = 0;
    private int $maxReplicaCount = 100;
    private Rollout $rollout;
    private ScalingStrategy $scalingStrategy;

    /**
     * @var Trigger[]
     */
    private array $triggers = [];

    private ObjectMeta $meta;

    public function __construct(private readonly JobSpec $jobTargetRef)
    {
        $this->meta = new ObjectMeta();
        $this->rollout = new Rollout();
        $this->scalingStrategy = new ScalingStrategy();
    }

    public function metadata(): ObjectMeta
    {
        return $this->meta;
    }

    public function jobTargetRef(): JobSpec
    {
        return $this->jobTargetRef;
    }

    public function getPollingInterval(): int
    {
        return $this->pollingInterval;
    }

    public function setPollingInterval(int $pollingInterval): static
    {
        $this->pollingInterval = $pollingInterval;

        return $this;
    }

    public function getSuccessfulJobsHistoryLimit(): int
    {
        return $this->successfulJobsHistoryLimit;
    }

    public function setSuccessfulJobsHistoryLimit(int $successfulJobsHistoryLimit): static
    {
        $this->successfulJobsHistoryLimit = $successfulJobsHistoryLimit;

        return $this;
    }

    public function getFailedJobsHistoryLimit(): int
    {
        return $this->failedJobsHistoryLimit;
    }

    public function setFailedJobsHistoryLimit(int $failedJobsHistoryLimit): static
    {
        $this->failedJobsHistoryLimit = $failedJobsHistoryLimit;

        return $this;
    }

    public function getEnvSourceContainerName(): ?string
    {
        return $this->envSourceContainerName;
    }

    public function setEnvSourceContainerName(string $envSourceContainerName): static
    {
        $this->envSourceContainerName = $envSourceContainerName;

        return $this;
    }

    public function getMinReplicaCount(): int
    {
        return $this->minReplicaCount;
    }

    public function setMinReplicaCount(int $minReplicaCount): static
    {
        $this->minReplicaCount = $minReplicaCount;

        return $this;
    }

    public function getMaxReplicaCount(): int
    {
        return $this->maxReplicaCount;
    }

    public function setMaxReplicaCount(int $maxReplicaCount): static
    {
        $this->maxReplicaCount = $maxReplicaCount;

        return $this;
    }

    public function rollout(): Rollout
    {
        return $this->rollout;
    }

    public function scalingStrategy(): ScalingStrategy
    {
        return $this->scalingStrategy;
    }

    public function getTriggers(): array
    {
        return $this->triggers;
    }

    public function setTriggers(array $triggers): static
    {
        $this->triggers = $triggers;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'apiVersion' => self::API_VERSION,
            'kind' => self::KIND,
            'metadata' => $this->meta,
            'spec' => [
                'pollingInterval' => $this->pollingInterval,
                'successfulJobsHistoryLimit' => $this->successfulJobsHistoryLimit,
                'failedJobsHistoryLimit' => $this->failedJobsHistoryLimit,
                'envSourceContainerName' => $this->envSourceContainerName,
                'minReplicaCount' => $this->minReplicaCount,
                'maxReplicaCount' => $this->maxReplicaCount,
                'scalingStrategy' => $this->scalingStrategy,
                'jobTargetRef' => $this->jobTargetRef,
                'triggers' => $this->triggers,
            ],
        ];
    }
}
