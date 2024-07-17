<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger;

use Dealroadshow\Bundle\KedaBundle\API\ScaledObject\Trigger;
use Dealroadshow\K8S\Framework\Core\Autoscaling\Metric\TargetType;

interface TriggerBuilderInterface
{
    public function build(): Trigger;
    public function metricType(TargetType $type): static;
    public function useCachedMetrics(bool $value): static;
}
