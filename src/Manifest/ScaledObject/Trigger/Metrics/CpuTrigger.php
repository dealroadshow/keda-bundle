<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\Metrics;

class CpuTrigger extends AbstractStandardMetricTrigger
{
    protected static function type(): string
    {
        return 'cpu';
    }
}
