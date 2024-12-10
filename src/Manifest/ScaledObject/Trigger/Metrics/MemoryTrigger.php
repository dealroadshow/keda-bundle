<?php

declare(strict_types=1);

namespace Dealroadshow\Bundle\KedaBundle\Manifest\ScaledObject\Trigger\Metrics;

class MemoryTrigger extends AbstractStandardMetricTrigger
{
    protected static function type(): string
    {
        return 'memory';
    }
}
