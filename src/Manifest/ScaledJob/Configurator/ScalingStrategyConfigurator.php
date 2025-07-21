<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledJob\Configurator;

use Dealroadshow\Bundle\KedaBundle\API\ScaledJob\ScalingStrategy;

final readonly class ScalingStrategyConfigurator
{
    public function __construct(private ScalingStrategy $scalingStrategy)
    {
    }

    public function setStrategy(string $strategy): self
    {
        $this->scalingStrategy->setStrategy($strategy);

        return $this;
    }

    public function setCustomScalingQueueLengthDeduction(int $customScalingQueueLengthDeduction): self
    {
        $this->scalingStrategy->setCustomScalingQueueLengthDeduction($customScalingQueueLengthDeduction);

        return $this;
    }

    public function setCustomScalingRunningJobPercentage(float $customScalingRunningJobPercentage): self
    {
        $this->scalingStrategy->setCustomScalingRunningJobPercentage($customScalingRunningJobPercentage);

        return $this;
    }

    public function setPendingPodConditions(array $pendingPodConditions): self
    {
        $this->scalingStrategy->setPendingPodConditions($pendingPodConditions);

        return $this;
    }

    public function setMultipleScalersCalculation(string $multipleScalersCalculation): self
    {
        $this->scalingStrategy->setMultipleScalersCalculation($multipleScalersCalculation);

        return $this;
    }
}
