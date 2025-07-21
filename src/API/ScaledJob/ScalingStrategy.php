<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\API\ScaledJob;

class ScalingStrategy implements \JsonSerializable
{
    private string $strategy = 'default';
    private ?int $customScalingQueueLengthDeduction;
    private ?string $customScalingRunningJobPercentage;

    /**
     * @var string[]|null
     */
    private ?array $pendingPodConditions = null;
    private string $multipleScalersCalculation = 'max';

    public function getStrategy(): string
    {
        return $this->strategy;
    }

    public function setStrategy(string $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function getCustomScalingQueueLengthDeduction(): ?int
    {
        return $this->customScalingQueueLengthDeduction;
    }

    public function setCustomScalingQueueLengthDeduction(int $customScalingQueueLengthDeduction): void
    {
        $this->customScalingQueueLengthDeduction = $customScalingQueueLengthDeduction;
    }

    public function getCustomScalingRunningJobPercentage(): ?string
    {
        return $this->customScalingRunningJobPercentage;
    }

    public function setCustomScalingRunningJobPercentage(float $customScalingRunningJobPercentage): void
    {
        $this->customScalingRunningJobPercentage = (string)$customScalingRunningJobPercentage;
    }

    public function getPendingPodConditions(): ?array
    {
        return $this->pendingPodConditions;
    }

    public function setPendingPodConditions(array $pendingPodConditions): void
    {
        $this->pendingPodConditions = $pendingPodConditions;
    }

    public function getMultipleScalersCalculation(): string
    {
        return $this->multipleScalersCalculation;
    }

    public function setMultipleScalersCalculation(string $multipleScalersCalculation): void
    {
        $this->multipleScalersCalculation = $multipleScalersCalculation;
    }

    public function jsonSerialize(): array
    {
        return [
            'strategy' => $this->strategy,
            'customScalingQueueLengthDeduction' => $this->customScalingQueueLengthDeduction,
            'customScalingRunningJobPercentage' => $this->customScalingRunningJobPercentage,
            'pendingPodConditions' => $this->pendingPodConditions,
            'multipleScalersCalculation' => $this->multipleScalersCalculation,
        ];
    }
}
