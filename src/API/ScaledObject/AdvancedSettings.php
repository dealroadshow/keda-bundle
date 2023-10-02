<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledObject;

final class AdvancedSettings implements \JsonSerializable
{
    private bool $restoreToOriginalReplicaCount = false;
    private HPAConfig $horizontalPodAutoscalerConfig;

    public function __construct()
    {
        $this->horizontalPodAutoscalerConfig = new HPAConfig();
    }

    public function getRestoreToOriginalReplicaCount(): bool
    {
        return $this->restoreToOriginalReplicaCount;
    }

    public function setRestoreToOriginalReplicaCount(bool $value): self
    {
        $this->restoreToOriginalReplicaCount = $value;

        return $this;
    }

    public function horizontalPodAutoscalerConfig(): HPAConfig
    {
        return $this->horizontalPodAutoscalerConfig;
    }

    public function jsonSerialize(): array
    {
        return [
            'restoreToOriginalReplicaCount' => $this->restoreToOriginalReplicaCount,
            'horizontalPodAutoscalerConfig' => $this->horizontalPodAutoscalerConfig,
        ];
    }
}
