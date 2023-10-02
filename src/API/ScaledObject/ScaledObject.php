<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledObject;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\ObjectMeta;

class ScaledObject implements APIResourceInterface
{
    public const API_VERSION = 'keda.sh/v1alpha1';
    public const KIND = 'ScaledObject';

    private ObjectMeta $meta;
    private ScaleTargetReference|null $scaleTargetRef;
    private int $pollingInterval = 30;
    private int $cooldownPeriod = 300;
    private int|null $idleReplicaCount = null;
    private int $minReplicaCount = 0;
    private int $maxReplicaCount = 100;
    private Fallback|null $fallback = null;
    private AdvancedSettings $advanced;

    /**
     * @var ScaleTrigger[]
     */
    private array $triggers = [];

    public function __construct()
    {
        $this->meta = new ObjectMeta();
        $this->advanced = new AdvancedSettings();
    }

    public function metadata(): ObjectMeta
    {
        return $this->meta;
    }

    public function getScaleTargetRef(): ScaleTargetReference|null
    {
        return $this->scaleTargetRef;
    }

    public function setScaleTargetRef(ScaleTargetReference $scaleTargetRef): static
    {
        $this->scaleTargetRef = $scaleTargetRef;

        return $this;
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

    public function getCooldownPeriod(): int
    {
        return $this->cooldownPeriod;
    }

    public function setCooldownPeriod(int $cooldownPeriod): static
    {
        $this->cooldownPeriod = $cooldownPeriod;

        return $this;
    }

    public function getIdleReplicaCount(): int|null
    {
        return $this->idleReplicaCount;
    }

    public function setIdleReplicaCount(int $idleReplicaCount): static
    {
        $this->idleReplicaCount = $idleReplicaCount;

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

    public function setFallback(Fallback $fallback): static
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function advanced(): AdvancedSettings
    {
        return $this->advanced;
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
            'kind' => 'ScaledObject',
            'metadata' => $this->meta,
            'spec' => [
                'scaleTargetRef' => $this->scaleTargetRef,
                'pollingInterval' => $this->pollingInterval,
                'cooldownPeriod' => $this->cooldownPeriod,
                'idleReplicaCount' => $this->idleReplicaCount,
                'minReplicaCount' => $this->minReplicaCount,
                'maxReplicaCount' => $this->maxReplicaCount,
                'fallback' => $this->fallback,
                'advanced' => $this->advanced,
                'triggers' => $this->triggers,
            ],
        ];
    }
}
